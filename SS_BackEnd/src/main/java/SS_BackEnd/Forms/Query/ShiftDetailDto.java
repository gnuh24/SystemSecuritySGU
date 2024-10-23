package SS_BackEnd.Forms.Query;

import java.time.LocalDateTime;

public interface ShiftDetailDto {
    String getProfileCode();
    String getProfileName();
    Long getShiftId();
    LocalDateTime getShiftStartTime();
    LocalDateTime getShiftEndTime();
    Boolean getIsOvertime();
    LocalDateTime getCheckInTime();
    String getCheckInStatus();
    LocalDateTime getCheckOutTime();
    String getCheckOutStatus();
}

