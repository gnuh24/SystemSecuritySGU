package SS_BackEnd.Services.StatisticServices;

import SS_BackEnd.Forms.Query.IProfileWorkSummary;
import SS_BackEnd.Forms.Query.ProfileWorkSummary;
import SS_BackEnd.Forms.Query.ShiftDetailDto;
import SS_BackEnd.Repositories.IProfileRepository;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.Banner;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.util.List;

@Service
public class StatisticServive implements IStatisticService {

    @Autowired
    private IProfileRepository profileRepository;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public List<IProfileWorkSummary> getProfileWorkSummary(Boolean isOT, String startDate, String endDate, String sort) {

//        return profileRepository.getProfileStatistics(isOT, startDate, endDate, sort);
        return profileRepository.getProfileStatistics(isOT, startDate, endDate);


    }

    @Override
    public List<ShiftDetailDto> getShiftDetails(String profileCode, String startDate, String endDate) {
        // Call the repository method and return the result
        return profileRepository.getShiftDetailsByProfileCode(profileCode, startDate, endDate);
    }

}
