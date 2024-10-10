package SS_BackEnd.Services;

import SS_BackEnd.Entities.Shift;
import SS_BackEnd.Forms.Shift.ShiftCreateForm;
import SS_BackEnd.Forms.Shift.ShiftFilterForm;
import SS_BackEnd.Forms.Shift.ShiftUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

public interface IShiftService {

    Boolean isShiftExistsById(Integer id);
    Page<Shift> getAllShiftByManager(Pageable pageable, ShiftFilterForm form, String search);
    Shift getShiftById(Integer id);
    Shift createShift(ShiftCreateForm form);
    Shift updateShift(ShiftUpdateForm form);
}
