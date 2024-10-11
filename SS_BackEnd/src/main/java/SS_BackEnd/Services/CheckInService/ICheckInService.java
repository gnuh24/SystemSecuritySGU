package SS_BackEnd.Services.CheckInService;

import SS_BackEnd.Configuration.Exception.AuthException.EmployeeTerminatedException;
import SS_BackEnd.Entities.CheckIn;
import SS_BackEnd.Forms.CheckIn.CheckInCreateForm;
import org.springframework.data.domain.Pageable;

import java.io.IOException;
import java.util.List;

public interface ICheckInService {
    List<CheckIn> getAllCheckInByShiftId(Pageable pageable, Integer shiftId);
    CheckIn createCheckIn(CheckInCreateForm form) throws IOException, EmployeeTerminatedException;

    Boolean isProfileCheckInInThisShift(Integer shift, String profileCode);

    CheckIn getCheckInById(Integer shiftId, String profileCode);
}

