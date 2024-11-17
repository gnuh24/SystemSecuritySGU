package SS_BackEnd.Forms.ProfileForms;

import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class ProfileDTOListElement {

    private String code;
    private String fullname;
    private String phone;
    private String position;
    private String email;
    private String status;

}
