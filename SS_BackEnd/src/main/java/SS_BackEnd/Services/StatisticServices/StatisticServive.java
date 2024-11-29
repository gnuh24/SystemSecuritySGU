package SS_BackEnd.Services.StatisticServices;

import SS_BackEnd.Forms.Query.*;
import SS_BackEnd.Repositories.IProfileRepository;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.stream.Collectors;

@Service
public class StatisticServive implements IStatisticService {

    @Autowired
    private IProfileRepository profileRepository;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public List<IProfileWorkSummary> getProfileWorkSummary(String startDate, String endDate) {
        // Fetch data from repositories
        List<IProfileWorkSummaryOfficial> officials = profileRepository.getProfileStatisticsOfficalShift(startDate, endDate);
        List<IProfileWorkSummaryOT> otList = profileRepository.getProfileStatisticsOTShift(startDate, endDate);

        // Create a map using officialList
        Map<String, ProfileWorkSummary> summaryMap = new HashMap<>();
        for (IProfileWorkSummaryOfficial official : officials) {
            // Initialize ProfileWorkSummary with official data
            ProfileWorkSummary summary = new ProfileWorkSummary(
                official.getProfileCode(),
                official.getProfileName(),
                official.getTotalHoursWorkedOfficial(),
                0.0, // Placeholder for OT hours
                official.getTotalLateMinutes(),
                official.getTotalEarlyLeavingMinutes(),
                official.getTotalShiftSignUps(),
                official.getTotalWorkedShifts(),
                official.getTotalMissedShifts()
            );
            summaryMap.put(official.getProfileCode(), summary);
        }
        System.err.println("Wave 2");

        // Update the map with OT data
        for (IProfileWorkSummaryOT ot : otList) {
            ProfileWorkSummary summary = summaryMap.get(ot.getProfileCode());
            if (summary != null) {
                // Add OT-specific values to the existing summary
                summary.setTotalHoursWorkedOT(ot.getTotalHoursWorkedOT());



                summary.setTotalLateMinutes(summary.getTotalLateMinutes() + ot.getTotalLateMinutes());

                summary.setTotalEarlyLeavingMinutes(summary.getTotalEarlyLeavingMinutes() + ot.getTotalEarlyLeavingMinutes());
                summary.setTotalShiftSignUps(summary.getTotalShiftSignUps() + ot.getTotalShiftSignUps());
                summary.setTotalWorkedShifts(summary.getTotalWorkedShifts() + ot.getTotalWorkedShifts());
                summary.setTotalMissedShifts(summary.getTotalMissedShifts() + ot.getTotalMissedShifts());
            }
        }

        // Convert the map values to a list and return
        return new ArrayList<>(summaryMap.values());
    }


    @Override
    public List<IProfileWorkSummaryOfficial> getProfileWorkSummaryOfficial(String startDate, String endDate) {
        return profileRepository.getProfileStatisticsOfficalShift(startDate, endDate);
    }

    @Override
    public List<IProfileWorkSummaryOT> getProfileWorkSummaryOT(String startDate, String endDate) {
        return profileRepository.getProfileStatisticsOTShift(startDate, endDate);
    }

    @Override
    public List<ShiftDetailDto> getShiftDetails(String profileCode, String startDate, String endDate) {
        // Call the repository method and return the result
        return profileRepository.getShiftDetailsByProfileCode(profileCode, startDate, endDate);
    }


}
