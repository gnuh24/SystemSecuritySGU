package SS_BackEnd.Forms.CheckOut;

import SS_BackEnd.Entities.CheckIn;
import SS_BackEnd.Entities.CheckOut;
import SS_BackEnd.Forms.ProfileForms.ProfileDTOListElement;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.Data;

import java.time.LocalDateTime;

@Data
public class CheckOutDTOForCreateCheckOut {

    private Integer shiftId;

    private CheckOut.Status status;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime checkOutTime;

    private String image;

    private ProfileDTOListElement profile;

}
