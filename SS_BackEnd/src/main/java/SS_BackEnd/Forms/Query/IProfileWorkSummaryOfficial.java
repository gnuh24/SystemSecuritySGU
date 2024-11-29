package SS_BackEnd.Forms.Query;

public interface IProfileWorkSummaryOfficial {
    String getProfileCode();
    String getProfileName();
    Double getTotalHoursWorkedOfficial();
    Integer getTotalLateMinutes();
    Integer getTotalEarlyLeavingMinutes();
    Integer getTotalShiftSignUps();
    Integer getTotalWorkedShifts();
    Integer getTotalMissedShifts();
}
