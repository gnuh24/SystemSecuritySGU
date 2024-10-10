package SS_BackEnd.Services;

import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Entities.Shift;
import SS_BackEnd.Entities.ShiftSignUp;
import SS_BackEnd.Repositories.IShiftSignUpRepository;
import jakarta.persistence.EntityNotFoundException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Lazy;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

@Service
public class ShiftSignUpService implements IShiftSignUpService{

    @Autowired
    private IShiftSignUpRepository shiftSignUpRepository;

    @Autowired
    @Lazy
    private IShiftService shiftService;

    @Autowired
    private IProfileService profileService;


    @Override
    public List<ShiftSignUp> createSignUp(Integer shiftId, List<String> listProfile) {

        if (!shiftService.isShiftExistsById(shiftId))
        {
            throw new EntityNotFoundException("Không tìm thấy ca làm tới ID: " + shiftId);
        }

        // List to store created ShiftSignUp entities
        List<ShiftSignUp> createdSignUps = new ArrayList<>();

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

            // Add to the created list
            createdSignUps.add(signUp);
        }

        // Return the list of created ShiftSignUps
        return createdSignUps;
    }

}
