package SS_BackEnd.Forms.Query;

import lombok.Data;

@Data
public class ProfileWorkSummary {
    private String profileCode;
    private String profileName;
    private Double totalHoursWorkedOfficial;
    private Double totalHoursWorkedOT;
    private Long totalMinutesLate;
    private Long totalMinutesLeavingEarly;
    private Long totalShiftSignUp;
    private Long totalWorkingShift;
    private Long totalDaysNotWorked;

    // Getters and Setters
}

