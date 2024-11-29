package SS_BackEnd.Services.StatisticServices;

import SS_BackEnd.Forms.Query.IProfileWorkSummary;
import SS_BackEnd.Forms.Query.IProfileWorkSummaryOfficial;
import SS_BackEnd.Forms.Query.IProfileWorkSummaryOT;
import SS_BackEnd.Forms.Query.ShiftDetailDto;

import java.util.List;

public interface IStatisticService {
    List<IProfileWorkSummary> getProfileWorkSummary(String startDate, String endDate);
    List<IProfileWorkSummaryOfficial> getProfileWorkSummaryOfficial(String startDate, String endDate);
    List<IProfileWorkSummaryOT> getProfileWorkSummaryOT(String startDate, String endDate);

    List<ShiftDetailDto> getShiftDetails(String profileCode, String startDate, String endDate);
}
