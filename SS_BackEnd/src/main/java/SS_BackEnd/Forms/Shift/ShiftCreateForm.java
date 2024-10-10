package SS_BackEnd.Forms.Shift;

import jakarta.validation.constraints.FutureOrPresent;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Size;
import lombok.Data;

import java.time.LocalDateTime;
import java.util.List;

@Data
public class ShiftCreateForm {


    @NotBlank(message = "Tên ca không được để trống")
    @Size(min = 1, max = 255, message = "Tên ca phải có từ 1 đến 255 ký tự")
    private String shiftName;

    @NotNull(message = "Thời gian bắt đầu không được để trống")
    @FutureOrPresent(message = "Thời gian bắt đầu phải ở hiện tại hoặc tương lai")
    private LocalDateTime startTime;

    @NotNull(message = "Thời gian kết thúc không được để trống")
    @FutureOrPresent(message = "Thời gian kết thúc phải ở hiện tại hoặc tương lai")
    private LocalDateTime endTime;

    @NotNull(message = "Thời gian bắt đầu nghỉ không được để trống")
    @FutureOrPresent(message = "Thời gian bắt đầu nghỉ phải ở hiện tại hoặc tương lai")
    private LocalDateTime breakStartTime;

    @NotNull(message = "Thời gian kết thúc nghỉ không được để trống")
    @FutureOrPresent(message = "Thời gian kết thúc nghỉ phải ở hiện tại hoặc tương lai")
    private LocalDateTime breakEndTime;

    @NotNull(message = "Trạng thái hoạt động không được để trống")
    private Boolean isActive;

    @NotNull(message = "Trạng thái OT không được để trống")
    private Boolean isOT;

    private List<String> listProfile;
}
