package SS_BackEnd.Services.CheckInService;

import SS_BackEnd.Configuration.Exception.AuthException.EmployeeTerminatedException;
import SS_BackEnd.Configuration.Exception.EntityAlreadyExistsException;
import SS_BackEnd.Entities.CheckIn;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Entities.Shift;
import SS_BackEnd.Forms.CheckIn.CheckInCreateForm;
import SS_BackEnd.Other.ImageService;
import SS_BackEnd.Repositories.ICheckInRepository;
import SS_BackEnd.Services.APIModelService.IModelService;
import SS_BackEnd.Services.APIModelService.ModelService;
import SS_BackEnd.Services.EmailServices.IEmailService;
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
public class CheckInService implements ICheckInService{

    @Autowired
    private ICheckInRepository checkInRepository;

    @Autowired
    private IShiftService shiftService;

    @Autowired
    private IProfileService profileService;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private IEmailService emailService;

    @Autowired
    private IShiftSignUpService shiftSignUpService;

    @Autowired
    private IModelService modelService;

    @Override
    public List<CheckIn> getAllCheckInByShiftId(Pageable pageable, Integer shiftId) {

        if (!shiftService.isShiftExistsById(shiftId)){
            throw new EntityNotFoundException("Không tìm thấy ca làm id: " + shiftId);
        }

        return checkInRepository.findAllByIdShiftId(pageable, shiftId);
    }

    @Override
    public CheckIn createCheckIn(CheckInCreateForm form) throws IOException, EmployeeTerminatedException {

        Shift shift = shiftService.getShiftById(form.getShiftId());
        if (shift == null){
            throw new EntityNotFoundException("Không tìm thấy ca làm có Id: " + form.getShiftId());
        }

        Profile profile = profileService.getProfileById(form.getProfileCode());
        if (profile == null){
            throw new EntityNotFoundException("Không tìm thấy nhân viên có code: " + form.getProfileCode());
        }

        if (!shiftSignUpService.isThisShiftIncludesThisProfile(shift.getId(), profile.getCode())){
            throw new EntityNotFoundException("Nhân viên " + form.getProfileCode() + " chưa được đăng ký vào ca làm " + shift.getId());
        }

        if (!profile.getStatus()){
            throw new EmployeeTerminatedException("Nhân viên đã nghỉ việc không thể check in !!");
        }


        CheckIn existsCheckIn = getCheckInById(form.getShiftId(), form.getProfileCode());
        if ( existsCheckIn != null ){
            throw new EntityAlreadyExistsException("Nhân viên " + form.getProfileCode() + " đã checkIn ca làm ");
        }

        String profileCodeReturnedByModel = modelService.callAPIRecognition(form.getImage());
        System.err.println("Model: " + profileCodeReturnedByModel);
        System.err.println("Nhân viên: " + profile.getCode());
        if (!profileCodeReturnedByModel.equals(profile.getCode())){
            throw new EntityNotFoundException("Vân tay không khớp với nhân viên " + profile.getCode());
        }


        CheckIn entity = modelMapper.map(form, CheckIn.class);

        if (shift.getStartTime().isBefore(LocalDateTime.now())){
            entity.setStatus(CheckIn.Status.Late);
        }else{
            entity.setStatus(CheckIn.Status.OnTime);
        }

        entity.setShift(shift);
        entity.setProfile(profile);

        String path = ImageService.saveImage(ImageService.checkInImage, form.getImage());
        entity.setImage(path);

        return checkInRepository.save(entity);
    }

    @Override
    public Boolean isProfileCheckInInThisShift(Integer shift, String profileCode) {
        CheckIn.CheckInId id = new CheckIn.CheckInId(shift, profileCode);
        return checkInRepository.existsById(id);
    }

    @Override
    public CheckIn getCheckInById(Integer shiftId, String profileCode){
        CheckIn.CheckInId id = new CheckIn.CheckInId(shiftId, profileCode);
        return checkInRepository.findById(id).orElse(null);
    }


}
