package SS_BackEnd.Services.ShiftServices;


import SS_BackEnd.Entities.Shift;
import SS_BackEnd.Forms.Shift.ShiftCreateForm;
import SS_BackEnd.Forms.Shift.ShiftFilterForm;
import SS_BackEnd.Forms.Shift.ShiftUpdateForm;
import SS_BackEnd.Repositories.IShiftRepository;
import SS_BackEnd.Services.ShiftSignUpServices.IShiftSignUpService;
import SS_BackEnd.Specification.ShiftSpecification;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.time.LocalDateTime;
import java.util.List;

@Service
public class ShiftService implements IShiftService {

    @Autowired
    private IShiftRepository shiftRepository;

    @Autowired
    private IShiftSignUpService shiftSignUpService;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public Boolean isShiftExistsById(Integer id) {
        return shiftRepository.existsById(id);
    }

    @Override
    public Page<Shift> getAllShiftByManager(Pageable pageable, ShiftFilterForm form, String search) {

        Specification<Shift> where = ShiftSpecification.buildWhere( search, form);

        return shiftRepository.findAll(where, pageable);
    }

    // Get shift by ID
    @Override
    public Shift getShiftById(Integer id) {
        return shiftRepository.findById(id).orElse(null);
    }

    // Create a new shift
    @Override
    @Transactional
    public Shift createShift(ShiftCreateForm form) throws Exception {

        if (form.getIsActive()){
            List<Shift> testStartTime = shiftRepository.findShiftsByTime(String.valueOf(form.getStartTime()));

            if (testStartTime.size() > 0){
                throw new Exception("Thời gian bắt đầu đã trùng với 1 ca làm trong hệ thống !!");
            }

            List<Shift> testEndTime = shiftRepository.findShiftsByTime(String.valueOf(form.getEndTime()));

            if (testEndTime.size() > 0){
                throw new Exception("Thời gian kết thúc đã trùng với 1 ca làm trong hệ thống !!");
            }
        }

        Shift shift = modelMapper.map(form, Shift.class);
        shift = shiftRepository.save(shift);
        shiftSignUpService.createSignUp(shift.getId(), form.getProfileCodes());
        return shift;
    }

    // Update an existing shift (PATCH)
    @Override
    public Shift updateShift(ShiftUpdateForm form) {
        Shift shift = getShiftById(form.getId()); // Ensure shift exists
        if (form.getStartTime() != null) {
            shift.setStartTime(form.getStartTime());
        }
        if (form.getEndTime() != null) {
            shift.setEndTime(form.getEndTime());
        }
        if (form.getBreakStartTime() != null) {
            shift.setBreakStartTime(form.getBreakStartTime());
        }
        if (form.getBreakEndTime() != null) {
            shift.setBreakEndTime(form.getBreakEndTime());
        }
        if (form.getShiftName() != null) {
            shift.setShiftName(form.getShiftName());
        }
        if (form.getIsOT() != null) {
            shift.setIsOT(form.getIsOT());
        }
        if (form.getIsActive() != null) {
            shift.setIsActive(form.getIsActive());
        }
        shift.setUpdateAt(LocalDateTime.now());
        return shiftRepository.save(shift);
    }

}
