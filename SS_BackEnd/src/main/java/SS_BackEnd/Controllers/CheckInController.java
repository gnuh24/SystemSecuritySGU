package SS_BackEnd.Controllers;

import SS_BackEnd.Configuration.Exception.AuthException.EmployeeTerminatedException;
import SS_BackEnd.Entities.CheckIn;
import SS_BackEnd.Entities.ShiftSignUp;
import SS_BackEnd.Forms.CheckIn.CheckInCreateForm;
import SS_BackEnd.Forms.CheckIn.CheckInDTOForCreateCheckIn;
import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Forms.Shift.ShiftDTOListElement;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpCreateForm;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpDTOForCreating;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpDeleteForm;
import SS_BackEnd.Other.ImageService;
import SS_BackEnd.Services.CheckInService.ICheckInService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.Resource;
import org.springframework.core.io.UrlResource;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.io.IOException;
import java.net.MalformedURLException;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.List;

@RestController
@RequestMapping("/api/CheckIn")
@CrossOrigin(origins = "*")
public class CheckInController {

    @Autowired
    private ICheckInService checkInService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/List")
    public ResponseEntity<Response<List<CheckInDTOForCreateCheckIn>>> getListCheckIn(Pageable pageable,
                                                                                     @RequestParam Integer shiftId){

        List<CheckIn> entities = checkInService.getAllCheckInByShiftId(pageable, shiftId);

        List<CheckInDTOForCreateCheckIn> dto = modelMapper.map( entities, new TypeToken<List<CheckInDTOForCreateCheckIn>>(){}.getType());

        Response<List<CheckInDTOForCreateCheckIn>> response = new Response<>();
        response.setData(dto);

        String reponseMessage = "Truy vấn thành công";
        if (dto.isEmpty()){
            reponseMessage = "Không tìm thấy bất cứ check in nào !!";
        }

        response.setStatus(200);
        response.setMessage(reponseMessage);
        return ResponseEntity.ok(response);

    }

    @GetMapping(value = "/Image")
    public ResponseEntity<Resource> getCheckInImageByPath(@RequestParam String image) throws MalformedURLException {

        Path imagePath = Paths.get(ImageService.checkInImage, image);
        Resource resource = new UrlResource(imagePath.toUri());

        return ResponseEntity.ok()
            .contentType(MediaType.IMAGE_JPEG)
            .header(HttpHeaders.CONTENT_DISPOSITION, "attachment; filename=\"" + resource.getFilename() + "\"")
            .body(resource);

    }

    @PostMapping("/Create")
    public ResponseEntity<Response<CheckInDTOForCreateCheckIn>> createCheckIn(@ModelAttribute @Valid CheckInCreateForm form) throws IOException, EmployeeTerminatedException {

        CheckIn entities = checkInService.createCheckIn(form);

        CheckInDTOForCreateCheckIn dto = modelMapper.map(entities , CheckInDTOForCreateCheckIn.class);

        Response<CheckInDTOForCreateCheckIn> response = new Response<>();
        response.setStatus(201);
        response.setMessage("Điểm danh ca làm thành công !");
        response.setData(dto);

        return ResponseEntity.status(HttpStatus.CREATED).body(response);
    }

}
