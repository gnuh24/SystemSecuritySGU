package SS_BackEnd.Forms.ShiftSignUp;

import SS_BackEnd.Forms.ProfileForms.ProfileDTOListElement;
import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.Data;

import java.time.LocalDateTime;

@Data
public class ShiftSignUpDTOForCreating {

    @JsonProperty("shiftId")
    private Integer idShiftId;

    private ProfileDTOListElement profile;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime signUpTime;

}
