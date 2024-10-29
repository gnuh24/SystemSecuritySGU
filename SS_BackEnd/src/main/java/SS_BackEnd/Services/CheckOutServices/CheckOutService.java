package SS_BackEnd.Services.CheckOutServices;

import SS_BackEnd.Configuration.Exception.AuthException.AccountBannedException;
import SS_BackEnd.Configuration.Exception.AuthException.EmployeeTerminatedException;
import SS_BackEnd.Configuration.Exception.EntityAlreadyExistsException;
import SS_BackEnd.Entities.CheckOut;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Entities.Shift;
import SS_BackEnd.Forms.CheckOut.CheckOutCreateForm;
import SS_BackEnd.Other.ImageService;
import SS_BackEnd.Repositories.ICheckOutRepository;
import SS_BackEnd.Services.ProfileServices.IProfileService;
import SS_BackEnd.Services.ShiftServices.IShiftService;
import SS_BackEnd.Services.ShiftSignUpServices.IShiftSignUpService;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import jakarta.persistence.EntityNotFoundException;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.FileSystemResource;
import org.springframework.data.domain.Pageable;
import org.springframework.http.*;
import org.springframework.stereotype.Service;
import org.springframework.util.LinkedMultiValueMap;
import org.springframework.util.MultiValueMap;
import org.springframework.web.client.RestTemplate;
import org.springframework.web.multipart.MultipartFile;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.time.LocalDateTime;
import java.util.List;

@Service
public class CheckOutService implements ICheckOutService {

    @Autowired
    private ICheckOutRepository checkOutRepository;

    @Autowired
    private IShiftService shiftService;

    @Autowired
    private IProfileService profileService;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private IShiftSignUpService shiftSignUpService;

    @Autowired
    private RestTemplate restTemplate;


    @Override
    public List<CheckOut> getAllCheckOutByShiftId(Pageable pageable, Integer shiftId) {

        if (!shiftService.isShiftExistsById(shiftId)) {
            throw new EntityNotFoundException("Không tìm thấy ca làm id: " + shiftId);
        }

        return checkOutRepository.findAllByIdShiftId(pageable, shiftId);
    }

    @Override
    public CheckOut createCheckOut(CheckOutCreateForm form) throws IOException, EmployeeTerminatedException {

        Shift shift = shiftService.getShiftById(form.getShiftId());
        if (shift == null) {
            throw new EntityNotFoundException("Không tìm thấy ca làm có Id: " + form.getShiftId());
        }

        Profile profile = profileService.getProfileById(form.getProfileCode());
        if (profile == null) {
            throw new EntityNotFoundException("Không tìm thấy nhân viên có code: " + form.getProfileCode());
        }

        if (!shiftSignUpService.isThisShiftIncludesThisProfile(shift.getId(), profile.getCode())){
            throw new EntityNotFoundException("Nhân viên " + form.getProfileCode() + " chưa được đăng ký vào ca làm " + shift.getId());
        }

        if (!profile.getStatus()) {
            throw new EmployeeTerminatedException("Nhân viên đã nghỉ việc không thể check out !!");
        }

        CheckOut checkOut = getCheckOutById(form.getShiftId(), form.getProfileCode());
        if (checkOut != null) {
            throw new EntityAlreadyExistsException("Nhân viên " + form.getProfileCode() + " đã checkOut ca làm ");
        }

        String profileCodeReturnedByModel = callAPIRecognition(form.getImage());
        System.err.println("Model: " + profileCodeReturnedByModel);
        System.err.println("Nhân viên: " + profile.getCode());
        if (!profileCodeReturnedByModel.equals(profile.getCode())){
            throw new EntityNotFoundException("Vân tay không khớp với nhân viên " + profile.getCode());
        }

        CheckOut entity = modelMapper.map(form, CheckOut.class);

        // Logic check-out: Kiểm tra thời gian kết thúc ca
        if (shift.getEndTime().isAfter(LocalDateTime.now())) {
            entity.setStatus(CheckOut.Status.LeavingEarly);
        } else {
            entity.setStatus(CheckOut.Status.OnTime);
        }

        entity.setShift(shift);
        entity.setProfile(profile);

        String path = ImageService.saveImage(ImageService.checkOutImage, form.getImage());
        entity.setImage(path);

        return checkOutRepository.save(entity);
    }

    @Override
    public Boolean isProfileCheckOutInThisShift(Integer shift, String profileCode) {
        CheckOut.CheckOutId id = new CheckOut.CheckOutId(shift, profileCode);
        return checkOutRepository.existsById(id);
    }

    @Override
    public CheckOut getCheckOutById(Integer shiftId, String profileCode) {
        CheckOut.CheckOutId id = new CheckOut.CheckOutId(shiftId, profileCode);
        return checkOutRepository.findById(id).orElse(null);
    }

    private String callAPIRecognition(MultipartFile file) throws IOException {
        // Convert MultipartFile to File
        File convFile = convertMultipartFileToFile(file);

        // Prepare headers
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.MULTIPART_FORM_DATA);

        // Create the body with file
        MultiValueMap<String, Object> body = new LinkedMultiValueMap<>();
        body.add("file", new FileSystemResource(convFile));

        // Wrap the body and headers into an HttpEntity
        HttpEntity<MultiValueMap<String, Object>> requestEntity = new HttpEntity<>(body, headers);

        // Make the request to the external API
        ResponseEntity<String> response = restTemplate.exchange(
            "http://127.0.0.1:5000/recognize",
            HttpMethod.POST,
            requestEntity,
            String.class
        );

        // Delete temporary file
        convFile.delete();

        // Parse JSON response to get "predicted_label"
        ObjectMapper objectMapper = new ObjectMapper();
        JsonNode jsonNode = objectMapper.readTree(response.getBody());

        return jsonNode.get("predicted_label").asText();
    }

    // Convert MultipartFile to File
    private File convertMultipartFileToFile(MultipartFile file) throws IOException {
        File convFile = new File(System.getProperty("java.io.tmpdir") + "/" + file.getOriginalFilename());
        try (FileOutputStream fos = new FileOutputStream(convFile)) {
            fos.write(file.getBytes());
        }
        return convFile;
    }
}
