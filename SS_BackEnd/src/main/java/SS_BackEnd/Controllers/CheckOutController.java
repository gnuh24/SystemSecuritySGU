package SS_BackEnd.Controllers;

import SS_BackEnd.Configuration.Exception.AuthException.EmployeeTerminatedException;
import SS_BackEnd.Entities.CheckOut;
import SS_BackEnd.Forms.CheckOut.CheckOutCreateForm;
import SS_BackEnd.Forms.CheckOut.CheckOutDTOForCreateCheckOut;
import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Other.ImageService;
import SS_BackEnd.Services.CheckOutServices.ICheckOutService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.Resource;
import org.springframework.core.io.UrlResource;
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
@RequestMapping("/api/CheckOut")
@CrossOrigin(origins = "*")
public class CheckOutController {

    @Autowired
    private ICheckOutService checkOutService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping(value = "/List")
    public ResponseEntity<Response<List<CheckOutDTOForCreateCheckOut>>> getListCheckOut(Pageable pageable,
                                                                                        @RequestParam Integer shiftId){

        List<CheckOut> entities = checkOutService.getAllCheckOutByShiftId(pageable, shiftId);

        List<CheckOutDTOForCreateCheckOut> dto = modelMapper.map(entities, new TypeToken<List<CheckOutDTOForCreateCheckOut>>(){}.getType());

        Response<List<CheckOutDTOForCreateCheckOut>> response = new Response<>();
        response.setData(dto);

        String responseMessage = "Truy vấn thành công";
        if (dto.isEmpty()){
            responseMessage = "Không tìm thấy bất cứ check out nào !!";
        }

        response.setStatus(200);
        response.setMessage(responseMessage);
        return ResponseEntity.ok(response);
    }

    @GetMapping(value = "/Image")
    public ResponseEntity<Resource> getCheckOutImageByPath(@RequestParam String image) throws MalformedURLException {

        Path imagePath = Paths.get(ImageService.checkOutImage, image);
        Resource resource = new UrlResource(imagePath.toUri());

        return ResponseEntity.ok()
            .contentType(MediaType.IMAGE_JPEG)
            .header(HttpHeaders.CONTENT_DISPOSITION, "attachment; filename=\"" + resource.getFilename() + "\"")
            .body(resource);
    }

    @PostMapping("/Create")
    public ResponseEntity<Response<CheckOutDTOForCreateCheckOut>> createCheckOut(@ModelAttribute @Valid CheckOutCreateForm form) throws IOException, EmployeeTerminatedException {

        CheckOut entities = checkOutService.createCheckOut(form);

        CheckOutDTOForCreateCheckOut dto = modelMapper.map(entities, CheckOutDTOForCreateCheckOut.class);

        Response<CheckOutDTOForCreateCheckOut> response = new Response<>();
        response.setStatus(201);
        response.setMessage("Điểm danh ra ca làm thành công !");
        response.setData(dto);

        return ResponseEntity.status(HttpStatus.CREATED).body(response);
    }
}
