package SS_BackEnd.Controllers;

import SS_BackEnd.Configuration.Exception.AuthException.AccountBannedException;
import SS_BackEnd.Configuration.Exception.AuthException.InvalidCredentialsException;
import SS_BackEnd.Forms.Account.LoginInputForm;
import SS_BackEnd.Forms.Account.LoginOutputForm;
import SS_BackEnd.Forms.Account.RefreshInputForm;
import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Services.IAccountService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.security.core.Authentication;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/Account")
@CrossOrigin(origins = "*")
public class AccountController {

    @Autowired
    private IAccountService accountService;

    @PostMapping("/Login")
    public ResponseEntity<Response<LoginOutputForm>> login(@ModelAttribute LoginInputForm form) {

        Response<LoginOutputForm> response = new Response<>();

        LoginOutputForm outputForm = accountService.signInForUser(form);
        response.setStatus(200);
        response.setMessage("Đăng nhập thành công !");
        response.setData(outputForm);

        return ResponseEntity.ok(response);

    }

    @PostMapping("/Refresh")
    public ResponseEntity<Response<LoginOutputForm>> refreshToken(@ModelAttribute RefreshInputForm form) {

        Response<LoginOutputForm> response = new Response<>();

        LoginOutputForm outputForm = accountService.refreshToken(form.getToken(), form.getRefreshToken());
        response.setStatus(200);
        response.setMessage("Refresh Token thành công !");
        response.setData(outputForm);

        return ResponseEntity.ok(response);


    }

}
