package SS_BackEnd.Forms.ProfileForms;

import SS_BackEnd.Entities.Profile;
import jakarta.validation.constraints.*;
import lombok.Data;

import java.time.LocalDate;


@Data
public class ProfileCreateForm {

    @PastOrPresent(message = "Ngày sinh không thể là ngày trong tương lai.")
    @NotNull(message = "Ngày sinh không được để trống.")
    private LocalDate birthday;

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

    @NotNull(message = "Chức vụ không được để trống.")
    private Profile.Position position;
}

