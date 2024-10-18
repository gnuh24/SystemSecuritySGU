package SS_BackEnd.Services.CheckOutServices;

import SS_BackEnd.Configuration.Exception.AuthException.AccountBannedException;
import SS_BackEnd.Configuration.Exception.AuthException.EmployeeTerminatedException;
import SS_BackEnd.Configuration.Exception.EntityAlreadyExistsException;
import SS_BackEnd.Entities.CheckOut;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Entities.Shift;
import SS_BackEnd.Forms.CheckOut.CheckOutCreateForm;
import SS_BackEnd.Other.ImageService;
import SS_BackEnd.Repositories.ICheckOutRepository;
import SS_BackEnd.Services.ProfileServices.IProfileService;
import SS_BackEnd.Services.ShiftServices.IShiftService;
import SS_BackEnd.Services.ShiftSignUpServices.IShiftSignUpService;
import jakarta.persistence.EntityNotFoundException;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import java.io.IOException;
import java.time.LocalDateTime;
import java.util.List;

@Service
public class CheckOutService implements ICheckOutService {

    @Autowired
    private ICheckOutRepository checkOutRepository;

    @Autowired
    private IShiftService shiftService;

    @Autowired
    private IProfileService profileService;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private IShiftSignUpService shiftSignUpService;

    @Override
    public List<CheckOut> getAllCheckOutByShiftId(Pageable pageable, Integer shiftId) {

        if (!shiftService.isShiftExistsById(shiftId)) {
            throw new EntityNotFoundException("Không tìm thấy ca làm id: " + shiftId);
        }

        return checkOutRepository.findAllByIdShiftId(pageable, shiftId);
    }

    @Override
    public CheckOut createCheckOut(CheckOutCreateForm form) throws IOException, EmployeeTerminatedException {

        Shift shift = shiftService.getShiftById(form.getShiftId());
        if (shift == null) {
            throw new EntityNotFoundException("Không tìm thấy ca làm có Id: " + form.getShiftId());
        }

        Profile profile = profileService.getProfileById(form.getProfileCode());
        if (profile == null) {
            throw new EntityNotFoundException("Không tìm thấy nhân viên có code: " + form.getProfileCode());
        }

        if (!shiftSignUpService.isThisShiftIncludesThisProfile(shift.getId(), profile.getCode())){
            throw new EntityNotFoundException("Nhân viên " + form.getProfileCode() + " chưa được đăng ký vào ca làm " + shift.getId());
        }

        if (!profile.getStatus()) {
            throw new EmployeeTerminatedException("Nhân viên đã nghỉ việc không thể check out !!");
        }

        CheckOut checkOut = getCheckOutById(form.getShiftId(), form.getProfileCode());
        if (checkOut != null) {
            throw new EntityAlreadyExistsException("Nhân viên " + form.getProfileCode() + " đã checkOut ca làm ");
        }

        CheckOut entity = modelMapper.map(form, CheckOut.class);

        // Logic check-out: Kiểm tra thời gian kết thúc ca
        if (shift.getEndTime().isAfter(LocalDateTime.now())) {
            entity.setStatus(CheckOut.Status.LeavingEarly);
        } else {
            entity.setStatus(CheckOut.Status.OnTime);
        }

        entity.setShift(shift);
        entity.setProfile(profile);

        String path = ImageService.saveImage(ImageService.checkOutImage, form.getImage());
        entity.setImage(path);

        return checkOutRepository.save(entity);
    }

    @Override
    public Boolean isProfileCheckOutInThisShift(Integer shift, String profileCode) {
        CheckOut.CheckOutId id = new CheckOut.CheckOutId(shift, profileCode);
        return checkOutRepository.existsById(id);
    }

    @Override
    public CheckOut getCheckOutById(Integer shiftId, String profileCode) {
        CheckOut.CheckOutId id = new CheckOut.CheckOutId(shiftId, profileCode);
        return checkOutRepository.findById(id).orElse(null);
    }
}
