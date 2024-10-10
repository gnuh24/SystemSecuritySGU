package SS_BackEnd.Forms.ShiftSignUp;


import jakarta.validation.constraints.NotEmpty;
import jakarta.validation.constraints.NotNull;
import lombok.Data;

import java.util.List;

@Data
public class ShiftSignUpDeleteForm {

    @NotNull(message = "Bạn không được bỏ trống shift id !")
    private Integer shiftId;

    @NotNull(message = "Bạn không được bỏ trống profile code !")
    private String profileCode;

}
