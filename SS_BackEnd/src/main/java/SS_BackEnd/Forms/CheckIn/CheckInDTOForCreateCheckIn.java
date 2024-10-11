package SS_BackEnd.Forms.CheckIn;

import SS_BackEnd.Entities.CheckIn;
import SS_BackEnd.Forms.ProfileForms.ProfileDTOListElement;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.Data;

import java.time.LocalDateTime;

@Data
public class CheckInDTOForCreateCheckIn {

    private Integer shiftId;

    private CheckIn.Status status;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime checkInTime;

    private String image;

    private ProfileDTOListElement profile;

}
