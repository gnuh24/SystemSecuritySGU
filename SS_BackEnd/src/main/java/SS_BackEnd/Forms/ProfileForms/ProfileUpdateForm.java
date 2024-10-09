package SS_BackEnd.Forms.ProfileForms;

import SS_BackEnd.Entities.Profile;
import jakarta.validation.constraints.*;
import lombok.Data;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDate;

@Data
public class ProfileUpdateForm {
    @NotBlank(message = "Mã hồ sơ không được để trống.")
    private String profileCode;

    @PastOrPresent(message = "Ngày sinh không thể là ngày trong tương lai.")
    private LocalDate birthday;

    @NotNull(message = "Bạn không được để trống trạng thái.")
    private Boolean status;

    @NotNull(message = "Giới tính không được để trống.")
    private Profile.Gender gender;

    @NotBlank(message = "Họ tên không được để trống.")
    @Size(min = 1, max = 255, message = "Họ tên phải từ 1 đến 255 ký tự.")
    private String fullname;

    @NotBlank(message = "Số điện thoại không được để trống.")
    private String phone;

    @NotBlank(message = "Email không được để trống.")
    @Email(message = "Email không hợp lệ.")
    private String email;
}
