package SS_BackEnd.Services.CheckOutServices;

import SS_BackEnd.Configuration.Exception.AuthException.EmployeeTerminatedException;
import SS_BackEnd.Entities.CheckOut;
import SS_BackEnd.Forms.CheckOut.CheckOutCreateForm;
import org.springframework.data.domain.Pageable;

import java.io.IOException;
import java.util.List;

public interface ICheckOutService {

    List<CheckOut> getAllCheckOutByShiftId(Pageable pageable, Integer shiftId);

    CheckOut createCheckOut(CheckOutCreateForm form) throws IOException, EmployeeTerminatedException;

    Boolean isProfileCheckOutInThisShift(Integer shift, String profileCode);

    CheckOut getCheckOutById(Integer shiftId, String profileCode);

}

