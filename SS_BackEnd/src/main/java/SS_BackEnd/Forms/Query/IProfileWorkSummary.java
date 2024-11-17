package SS_BackEnd.Forms.Query;

public interface IProfileWorkSummary {
    String getProfileCode();
    String getProfileName();
    Double getTotalHoursWorkedOfficial(); //Tổng số giờ làm việc chính chức
    Double getTotalHoursWorkedOT(); //Tổng số giờ OT
    Long getTotalMinutesLate(); //Tổng phút trễ\
    Long getTotalMinutesLeavingEarly(); // Tổng sút phút về sớm
    Long getTotalShiftSignUp(); // Tổng so ca làm đăng ký
    Long getTotalWorkingShift(); // Tổng số ca làm
    Long getTotalShiftsMissed(); // Tong so ca không làm
}