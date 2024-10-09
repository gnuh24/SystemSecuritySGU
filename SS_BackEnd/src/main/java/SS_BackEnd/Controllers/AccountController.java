package SS_BackEnd.Controllers;

import SS_BackEnd.Entities.Account;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.Account.*;
import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Forms.ProfileForms.ProfileDTOInDetail;
import SS_BackEnd.Forms.ProfileForms.ProfileDTOListElement;
import SS_BackEnd.Forms.ProfileForms.ProfileFilterForm;
import SS_BackEnd.Forms.ProfileForms.ProfileUpdateForm;
import SS_BackEnd.Services.IAccountService;
import jakarta.validation.Valid;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/Account")
@CrossOrigin(origins = "*")
public class AccountController {

    @Autowired
    private IAccountService accountService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping("/List")
    public ResponseEntity<Response<Page<AccountDTOListElement>>> getAllAccount(Pageable profile,
                                                                               String search,
                                                                               AccountFilterForm form) {

        Page<Account> entities = accountService.getAllAccountByAdmin(profile, form, search);

        List<AccountDTOListElement> dto = modelMapper.map(entities.getContent(), new TypeToken<List<AccountDTOListElement>>(){} .getType());

        Page<AccountDTOListElement> dtoPage = new PageImpl<>(dto, profile , entities.getTotalElements());


        Response<Page<AccountDTOListElement>> response = new Response<>();
        response.setData(dtoPage);

        String reponseMessage = "Truy ấn thành công";
        if (dto.isEmpty()){
            reponseMessage = "Không tìm thấy bất cứ Account nào theo yêu cầu !!";
        }

        response.setStatus(200);
        response.setMessage(reponseMessage);
        return ResponseEntity.ok(response);
    }

    @PatchMapping("/Update")
    public ResponseEntity<Response<AccountDTOListElement>> updateAccount(@ModelAttribute @Valid AccountUpdateForm form) {
        // Gọi service để cập nhật profile
        Account updatedAccount = accountService.updateAccount(form);
        AccountDTOListElement dto = modelMapper.map(updatedAccount, AccountDTOListElement.class);

        Response<AccountDTOListElement> response = new Response<>();
        response.setStatus(200);
        response.setMessage("Cập nhật trạng thái tài khoản thành công !");
        response.setData(dto);

        return ResponseEntity.ok(response);

    }

}
