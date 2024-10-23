package SS_BackEnd.Forms.Query;

public interface IProfileWorkSummary {
    String getProfileCode();
    String getProfileName();
    Double getTotalHoursWorkedOfficial();
    Double getTotalHoursWorkedOT();
    Long getTotalMinutesLate();
    Long getTotalMinutesLeavingEarly();
    Long getTotalShiftSignUp();
    Long getTotalWorkingShift();
    Long getTotalDaysNotWorked();
}