package SS_BackEnd.Controllers;

import SS_BackEnd.Entities.Shift;
import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Forms.Shift.*;
import SS_BackEnd.Services.ShiftServices.IShiftService;
import jakarta.persistence.EntityNotFoundException;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/Shift")
@CrossOrigin(origins = "*")
public class ShiftController {

    @Autowired
    private IShiftService shiftService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping("/List")
    public ResponseEntity<Response<Page<ShiftDTOListElement>>> getAllProfile(Pageable profile,
                                                                             @RequestParam(required = false) String search,
                                                                               ShiftFilterForm form) {
        Page<Shift> entities = shiftService.getAllShiftByManager(profile, form, search);
        List<ShiftDTOListElement> dto = modelMapper.map(entities.getContent(), new TypeToken<List<ShiftDTOListElement>>(){} .getType());
        Page<ShiftDTOListElement> dtoPage = new PageImpl<>(dto, profile , entities.getTotalElements());

        Response<Page<ShiftDTOListElement>> response = new Response<>();
        response.setData(dtoPage);

        String reponseMessage = "Truy ấn thành công";
        if (dto.isEmpty()){
            reponseMessage = "Không tìm thấy bất cứ Ca làm nào theo yêu cầu !!";
        }

        response.setStatus(200);
        response.setMessage(reponseMessage);
        return ResponseEntity.ok(response);
    }

    @GetMapping("/Detail")
    public ResponseEntity<Response<ShiftDTOInDetail>> getProfileByCode(@RequestParam Integer id) {
        Shift entities = shiftService.getShiftById(id);
        Response<ShiftDTOInDetail> response = new Response<>();

        if (entities == null) {
            throw new EntityNotFoundException("Không tìm thấy ca làm có id: " + id);
        }

        ShiftDTOInDetail dto = modelMapper.map(entities, ShiftDTOInDetail.class);
        response.setStatus(200);
        response.setMessage("Truy vấn thành công");
        response.setData(dto);
        return ResponseEntity.ok(response);
    }


    @PostMapping("/Create")
    public ResponseEntity<Response<ShiftDTOListElement>> createShift(@ModelAttribute @Valid ShiftCreateForm shiftCreateForm) {
        Shift createdShift = shiftService.createShift(shiftCreateForm);
            ShiftDTOListElement dto = modelMapper.map(createdShift, ShiftDTOListElement.class);

            Response<ShiftDTOListElement> response = new Response<>();
            response.setStatus(201);
            response.setMessage("Tạo ca làm thành công !");
            response.setData(dto);

            return ResponseEntity.status(HttpStatus.CREATED).body(response);
    }

    @PatchMapping("/Update")
    public ResponseEntity<Response<ShiftDTOListElement>> updateShift(@ModelAttribute @Valid ShiftUpdateForm shiftUpdateForm) {

        Shift updateShift = shiftService.updateShift(shiftUpdateForm);
        ShiftDTOListElement dto = modelMapper.map(updateShift, ShiftDTOListElement.class);

        Response<ShiftDTOListElement> response = new Response<>();
        response.setStatus(200);
        response.setMessage("Cập nhật ca làm thành công !");
        response.setData(dto);

        return ResponseEntity.ok(response);

    }


}
