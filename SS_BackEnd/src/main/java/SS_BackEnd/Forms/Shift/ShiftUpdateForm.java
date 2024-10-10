package SS_BackEnd.Forms.Shift;

import jakarta.validation.constraints.FutureOrPresent;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Size;
import lombok.Data;

import java.time.LocalDateTime;

@Data
public class ShiftUpdateForm {
    @NotNull(message = "ID ca làm việc không được để trống")
    private Integer id;

    @Size(min = 1, max = 255, message = "Tên ca làm việc phải có từ 1 đến 255 ký tự")
    private String shiftName;

    @FutureOrPresent(message = "Thời gian bắt đầu phải là thời gian hiện tại hoặc trong tương lai")
    private LocalDateTime startTime;

    @FutureOrPresent(message = "Thời gian kết thúc phải là thời gian hiện tại hoặc trong tương lai")
    private LocalDateTime endTime;

    @FutureOrPresent(message = "Thời gian bắt đầu nghỉ phải là thời gian hiện tại hoặc trong tương lai")
    private LocalDateTime breakStartTime;

    @FutureOrPresent(message = "Thời gian kết thúc nghỉ phải là thời gian hiện tại hoặc trong tương lai")
    private LocalDateTime breakEndTime;



    private Boolean isActive;

    private Boolean isOT;
}
