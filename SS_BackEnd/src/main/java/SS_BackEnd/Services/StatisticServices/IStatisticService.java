package SS_BackEnd.Services.StatisticServices;

import SS_BackEnd.Forms.Query.IProfileWorkSummary;
import SS_BackEnd.Forms.Query.ProfileWorkSummary;
import SS_BackEnd.Forms.Query.ShiftDetailDto;

import java.time.LocalDate;
import java.util.List;

public interface IStatisticService {
    List<IProfileWorkSummary> getProfileWorkSummary(Boolean isOT,String startDate, String endDate, String sort);
    List<ShiftDetailDto> getShiftDetails(String profileCode, String startDate, String endDate);
}
