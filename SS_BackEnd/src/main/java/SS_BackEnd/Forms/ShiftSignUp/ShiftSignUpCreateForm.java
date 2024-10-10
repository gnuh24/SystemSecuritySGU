package SS_BackEnd.Forms.ShiftSignUp;

import jakarta.validation.constraints.NotEmpty;
import jakarta.validation.constraints.NotNull;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.util.List;

@Data
public class ShiftSignUpCreateForm {

    @NotNull(message = "Bạn không được bỏ trống shift id !")
    private Integer shiftId;

    @NotEmpty(message = "Bạn không thể gửi 1 danh sách rỗng !")
    private List<String> profileCodes;

}
