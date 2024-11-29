package SS_BackEnd.Forms.Query;

import lombok.Data;

@Data
public class ProfileWorkSummary implements IProfileWorkSummary {
    private String profileCode;
    private String profileName;
    private Double totalHoursWorkedOfficial;
    private Double totalHoursWorkedOT;
    private Integer totalLateMinutes;
    private Integer totalEarlyLeavingMinutes;
    private Integer totalShiftSignUps;
    private Integer totalWorkedShifts;
    private Integer totalMissedShifts;

    public ProfileWorkSummary(String profileCode, String profileName, Double totalHoursWorkedOfficial,
                              Double totalHoursWorkedOT, Integer totalLateMinutes, Integer totalEarlyLeavingMinutes,
                              Integer totalShiftSignUps, Integer totalWorkedShifts, Integer totalMissedShifts) {
        this.profileCode = profileCode;
        this.profileName = profileName;
        this.totalHoursWorkedOfficial = totalHoursWorkedOfficial;
        this.totalHoursWorkedOT = totalHoursWorkedOT;
        this.totalLateMinutes = totalLateMinutes;
        this.totalEarlyLeavingMinutes = totalEarlyLeavingMinutes;
        this.totalShiftSignUps = totalShiftSignUps;
        this.totalWorkedShifts = totalWorkedShifts;
        this.totalMissedShifts = totalMissedShifts;
    }

}

