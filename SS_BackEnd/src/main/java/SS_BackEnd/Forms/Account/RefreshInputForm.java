package SS_BackEnd.Forms.Account;


import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class RefreshInputForm {

    private String token;
    private String refreshToken;

}
