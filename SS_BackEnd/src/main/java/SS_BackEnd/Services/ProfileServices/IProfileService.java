package SS_BackEnd.Services.ProfileServices;

import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.ProfileForms.ProfileCreateForm;
import SS_BackEnd.Forms.ProfileForms.ProfileFilterForm;
import SS_BackEnd.Forms.ProfileForms.ProfileUpdateForm;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.io.IOException;

public interface IProfileService {

    Boolean isProfileExistsByCode(String code);

    Profile getProfileById(String profileCode);

    Page<Profile> getAllProfiles(Pageable pageable, ProfileFilterForm form, String search);

    Profile createProfile(ProfileCreateForm profileCreateForm) throws IOException;

    Profile updateProfile(ProfileUpdateForm profileUpdateForm);
}
