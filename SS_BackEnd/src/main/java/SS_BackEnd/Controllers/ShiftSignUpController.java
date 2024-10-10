package SS_BackEnd.Controllers;

import SS_BackEnd.Entities.Shift;
import SS_BackEnd.Entities.ShiftSignUp;
import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Forms.ProfileForms.ProfileDTOListElement;
import SS_BackEnd.Forms.Shift.ShiftCreateForm;
import SS_BackEnd.Forms.Shift.ShiftDTOListElement;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpCreateForm;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpDTOForCreating;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpDTOForShiftDTOInDetail;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpDeleteForm;
import SS_BackEnd.Services.ShiftSignUpServices.IShiftSignUpService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.ArrayList;
import java.util.List;

@RestController
@RequestMapping("/api/ShiftSignUp")
@CrossOrigin(origins = "*")
public class ShiftSignUpController {

    @Autowired
    private IShiftSignUpService shiftSignUpService;

    @Autowired
    private ModelMapper modelMapper;

    @PostMapping("/Create")
    public ResponseEntity<Response<List<ShiftSignUpDTOForCreating>>> createShiftSignUp(@ModelAttribute @Valid ShiftSignUpCreateForm shiftSignUpCreateForm) {

        List<ShiftSignUp> entities = shiftSignUpService.createSignUp(shiftSignUpCreateForm);

        List<ShiftSignUpDTOForCreating> dto = modelMapper.map(entities , new TypeToken<List<ShiftSignUpDTOForCreating>>(){}.getType());

        Response<List<ShiftSignUpDTOForCreating>> response = new Response<>();
        response.setStatus(201);
        response.setMessage("Đăng ký ca làm thành công !");
        response.setData(dto);

        return ResponseEntity.status(HttpStatus.CREATED).body(response);
    }

    @DeleteMapping("/Delete")
    public ResponseEntity<Response<Void>> deleteShiftSignUp(@ModelAttribute @Valid ShiftSignUpDeleteForm shiftSignUpDeleteForm) {

        shiftSignUpService.deleteSignUp(shiftSignUpDeleteForm.getShiftId(), shiftSignUpDeleteForm.getProfileCode());

        Response<Void> response = new Response<>();
        response.setStatus(200);
        response.setMessage("Hủy đăng ký ca làm thành công !");
        response.setData(null);

        return ResponseEntity.status(HttpStatus.OK).body(response);
    }

}
