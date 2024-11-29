package SS_BackEnd.Forms.Query;

import com.fasterxml.jackson.annotation.JsonFormat;

import java.time.LocalDateTime;

public interface ShiftDetailDto {
    String getProfileCode();
    String getProfileName();
    Long getShiftId();

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    LocalDateTime getShiftStartTime();

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    LocalDateTime getShiftEndTime();

    Boolean getIsOvertime();

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    LocalDateTime getCheckInTime();

    String getCheckInStatus();

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    LocalDateTime getCheckOutTime();
    String getCheckOutStatus();
}

