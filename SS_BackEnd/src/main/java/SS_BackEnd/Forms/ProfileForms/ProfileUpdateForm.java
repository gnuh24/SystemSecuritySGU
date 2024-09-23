package SS_BackEnd.Forms.ProfileForms;

import SS_BackEnd.Entities.Profile;
import lombok.Data;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDate;

@Data
public class ProfileUpdateForm {
    private String profileCode;
    private LocalDate birthday;
    private Boolean status;
    private Profile.Gender gender;
    private String fullname;
    private String phone;
    private String email;
}
