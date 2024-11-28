package SS_BackEnd.Forms.Query;

public interface IProfileWorkSummaryOT {
    String getProfileCode();
    String getProfileName();
    Double getTotalHoursWorkedOT();
    Integer getTotalLateMinutes();
    Integer getTotalEarlyLeavingMinutes();
    Integer getTotalShiftSignUps();
    Integer getTotalWorkedShifts();
    Integer getTotalMissedShifts();
}

