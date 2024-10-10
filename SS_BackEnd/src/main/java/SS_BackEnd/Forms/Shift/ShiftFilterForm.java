package SS_BackEnd.Forms.Shift;

import jakarta.validation.constraints.Size;
import lombok.Data;

import java.time.LocalDate;

@Data
public class ShiftFilterForm {

    @Size(min = 1, max = 255, message = "Tên ca phải có từ 1 đến 255 ký tự")
    private String shiftName;

    private LocalDate targetDate;

    private Boolean isActive;

    private Boolean isOT;

}
