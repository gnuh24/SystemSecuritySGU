package SS_BackEnd.Controllers;
import javax.crypto.SecretKey;
import javax.crypto.spec.SecretKeySpec;

import SS_BackEnd.Configuration.WebSecurity.JWTUtils;
import SS_BackEnd.Forms.Account.LoginInputForm;
import SS_BackEnd.Forms.Account.LoginOutputForm;
import SS_BackEnd.Forms.Account.RefreshInputForm;
import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Services.AccountServices.IAccountService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.nio.charset.StandardCharsets;
import java.util.Arrays;
import java.util.Base64;

@RestController
@RequestMapping("/api/Auth")
public class AuthController {

    @Autowired
    private IAccountService accountService;

    @Autowired
    private JWTUtils jwtUtils;

    @GetMapping("/testJWT")
    public SecretKey testJWT(){
        //Khởi tạo Secret key
        String secreteStringForAccess = "123456";
        System.err.println("Serect String: " + secreteStringForAccess);

        byte [] serectBytes = secreteStringForAccess.getBytes(StandardCharsets.UTF_8);
        System.err.println("Serect (Bytes UTF8 not war): " + Arrays.toString(serectBytes));

        byte[] keyBytes1 = Base64.getDecoder().decode(serectBytes);
        System.err.println("Key bytes 1 (Not War): " + Arrays.toString(keyBytes1));

        SecretKey secretKeySpec = new SecretKeySpec(keyBytes1, "HmacSHA256");
        System.err.println("Secret Key encoded: " +  secretKeySpec);
        return secretKeySpec;
    }



























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
