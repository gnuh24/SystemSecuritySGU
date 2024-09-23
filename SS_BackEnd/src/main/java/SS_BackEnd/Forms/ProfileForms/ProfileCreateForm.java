package SS_BackEnd.Forms.ProfileForms;

import SS_BackEnd.Entities.Profile;
import lombok.Data;

import java.time.LocalDate;


@Data
public class ProfileCreateForm {

    private LocalDate birthday;
    private Profile.Gender gender;
    private String fullname;
    private String phone;
    private String email;
    private Profile.Position position;
}

