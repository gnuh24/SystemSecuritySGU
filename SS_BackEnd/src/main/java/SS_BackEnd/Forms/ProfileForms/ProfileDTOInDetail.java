package SS_BackEnd.Forms.ProfileForms;


import SS_BackEnd.Entities.Profile;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.time.LocalDate;
import java.time.LocalDateTime;

@Data
@NoArgsConstructor
public class ProfileDTOInDetail {

    private String code;
    private String fullname;
    private Profile.Gender gender;

    @JsonFormat(pattern = "dd/MM/yyyy")
    private LocalDate birthday;

    private String phone;
    private String email;
    private Boolean status;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createAt;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime updateAt;

}
