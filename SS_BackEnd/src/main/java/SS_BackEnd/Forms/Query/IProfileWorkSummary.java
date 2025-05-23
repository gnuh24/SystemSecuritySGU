package SS_BackEnd.Forms.Query;

public interface IProfileWorkSummary {
    String getProfileCode();
    String getProfileName();

    Double getTotalHoursWorkedOfficial();
    Double getTotalHoursWorkedOT();

    Integer getTotalLateMinutes();
    Integer getTotalEarlyLeavingMinutes();

    Integer getTotalShiftSignUps();
    Integer getTotalWorkedShifts();
    Integer getTotalMissedShifts();
}
