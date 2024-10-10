package SS_BackEnd.Forms.ShiftSignUp;

import SS_BackEnd.Forms.ProfileForms.ProfileDTOListElement;
import lombok.Data;

import java.time.LocalDateTime;

@Data
public class ShiftSignUpDTOForShiftDTOInDetail {

    private ProfileDTOListElement profile;

    private LocalDateTime signUpTime;

}
