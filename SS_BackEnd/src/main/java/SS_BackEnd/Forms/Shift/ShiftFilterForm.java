package SS_BackEnd.Forms.Shift;

import jakarta.validation.constraints.Size;
import lombok.Data;
import org.springframework.format.annotation.DateTimeFormat;

import java.time.LocalDate;
import java.util.Date;

@Data
public class ShiftFilterForm {

    @Size(min = 1, max = 255, message = "Tên ca phải có từ 1 đến 255 ký tự")
    private String shiftName;

    @DateTimeFormat(pattern = "yyyy-MM-dd")
    private Date targetDate;

    private Boolean isActive;

    private Boolean isOT;

    private Date from;

    private Date to;

}
