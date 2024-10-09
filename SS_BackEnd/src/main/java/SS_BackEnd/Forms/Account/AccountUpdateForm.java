package SS_BackEnd.Forms.Account;


import jakarta.validation.constraints.NotNull;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
public class AccountUpdateForm {

    @NotNull(message = "Bạn không được để trống tên tài khoản cần update !!")
    private Integer id;

    @NotNull(message = "Bạn không được để trống trạng thái !!")
    private Boolean status;

}
