package SS_BackEnd.Services.ShiftSignUpServices;

import SS_BackEnd.Configuration.Exception.EntityAlreadyExistsException;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Entities.ShiftSignUp;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpCreateForm;
import SS_BackEnd.Repositories.IShiftSignUpRepository;
import SS_BackEnd.Services.ProfileServices.IProfileService;
import SS_BackEnd.Services.ShiftServices.IShiftService;
import SS_BackEnd.Services.ShiftSignUpServices.IShiftSignUpService;
import jakarta.persistence.EntityNotFoundException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.List;

@Service
public class ShiftSignUpService implements IShiftSignUpService {

    @Autowired
    private IShiftSignUpRepository shiftSignUpRepository;

    @Autowired
    @Lazy
    private IShiftService shiftService;

    @Autowired
    private IProfileService profileService;


    @Override
    public Boolean isThisShiftIncludesThisProfile(Integer shiftId, String profileCode) {
        ShiftSignUp.ShiftSignUpId id = new ShiftSignUp.ShiftSignUpId();
        id.setShiftId(shiftId);
        id.setProfileCode(profileCode);
        return shiftSignUpRepository.existsById(id);
    }

    @Override
    public void createSignUp(Integer shiftId, List<String> listProfile) {

        if (!shiftService.isShiftExistsById(shiftId))
        {
            throw new EntityNotFoundException("Không tìm thấy ca làm tới ID: " + shiftId);
        }

        // Loop through each profileId in the list
        for (String profileId : listProfile) {

            if (!profileService.isProfileExistsByCode(profileId)){
                throw new EntityNotFoundException("Không tìm thấy profile có code: " + profileId);
            }

            // Create new ShiftSignUp
            ShiftSignUp signUp = new ShiftSignUp();
            ShiftSignUp.ShiftSignUpId id = new ShiftSignUp.ShiftSignUpId();
            id.setShiftId(shiftId);
            id.setProfileCode(profileId);
            signUp.setId(id);

            // Save the ShiftSignUp to the database
            shiftSignUpRepository.save(signUp);

        }

    }

    public Boolean isProfileSignUpForThisShift(Integer shiftId, String profileCode){
        ShiftSignUp.ShiftSignUpId id = new ShiftSignUp.ShiftSignUpId();
        id.setShiftId(shiftId);
        id.setProfileCode(profileCode);
        return shiftSignUpRepository.existsById(id);
    }

    @Override
    public List<ShiftSignUp> createSignUp(ShiftSignUpCreateForm form) {

        List<ShiftSignUp> result = new ArrayList<>();

        if (!shiftService.isShiftExistsById(form.getShiftId()))
        {
            throw new EntityNotFoundException("Không tìm thấy ca làm tới ID: " + form.getShiftId());
        }

        // Loop through each profileId in the list
        for (String profileId : form.getProfileCodes()) {

            Profile profile = profileService.getProfileById(profileId);

            if (profile == null){
                throw new EntityNotFoundException("Không tìm thấy profile có code: " + profileId);
            }

            if (isProfileSignUpForThisShift(form.getShiftId(), profileId)){
                throw new EntityAlreadyExistsException("Profile " + profileId + " đã được đăng ký vào ca làm " + form.getShiftId());
            }

            // Create new ShiftSignUp
            ShiftSignUp signUp = new ShiftSignUp();
            ShiftSignUp.ShiftSignUpId id = new ShiftSignUp.ShiftSignUpId();
            id.setShiftId(form.getShiftId());
            id.setProfileCode(profileId);
            signUp.setId(id);

            signUp.setProfile(profile);



            // Save the ShiftSignUp to the database
            signUp = shiftSignUpRepository.save(signUp);
            result.add(signUp);
        }

        return result;
    }

    @Override
    public void deleteSignUp(Integer shiftId, String profileCode) {

        if (!shiftService.isShiftExistsById(shiftId))
        {
            throw new EntityNotFoundException("Không tìm thấy ca làm tới ID: " + shiftId);
        }

        if (!profileService.isProfileExistsByCode(profileCode)){
            throw new EntityNotFoundException("Không tìm thấy profile có code: " + profileCode);
        }


        ShiftSignUp.ShiftSignUpId id = new ShiftSignUp.ShiftSignUpId();
        id.setShiftId(shiftId);
        id.setProfileCode(profileCode);

        shiftSignUpRepository.deleteById(id);

    }

}
