package SS_BackEnd.Forms.Account;

import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class LoginOutputForm {

    private Integer id;
    private String username;
    private String role;

    private String token;
    private String tokenExpirationTime;

    private String refreshToken;
    private String refreshTokenExpirationTime;

}
