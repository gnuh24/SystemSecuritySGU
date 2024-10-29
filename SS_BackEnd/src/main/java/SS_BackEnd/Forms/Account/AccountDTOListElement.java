package SS_BackEnd.Forms.Account;


import SS_BackEnd.Entities.Account;
import jakarta.persistence.*;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class AccountDTOListElement {

    private Integer id;

    private String username;

    private Account.Role role;

    private Boolean status;

    private String profileFullname;

    private String profilePhone;

    private String profileEmail;



}
