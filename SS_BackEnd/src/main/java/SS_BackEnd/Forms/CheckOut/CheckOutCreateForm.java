package SS_BackEnd.Forms.CheckOut;

import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import lombok.Data;
import org.springframework.web.multipart.MultipartFile;

@Data
public class CheckOutCreateForm {

    @NotNull(message = "Bạn không được bỏ trống shiftId !!")
    private Integer shiftId;

    @NotBlank(message = "Bạn không được bỏ trống profileCode !!")
    private String profileCode;

    @NotNull(message = "Bạn không thể để trống image !!")
    private MultipartFile image;

}
