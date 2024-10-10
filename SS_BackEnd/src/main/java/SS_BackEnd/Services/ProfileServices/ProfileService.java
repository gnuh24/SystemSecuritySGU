package SS_BackEnd.Services.ProfileServices;


import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.ProfileForms.ProfileCreateForm;
import SS_BackEnd.Forms.ProfileForms.ProfileFilterForm;
import SS_BackEnd.Forms.ProfileForms.ProfileUpdateForm;
import SS_BackEnd.Repositories.IProfileRepository;
import SS_BackEnd.Services.AccountServices.IAccountService;
import SS_BackEnd.Services.ProfileServices.IProfileService;
import SS_BackEnd.Specification.ProfileSpecification;
import jakarta.persistence.EntityNotFoundException;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.time.LocalDateTime;

@Service
public class ProfileService implements IProfileService {

    @Autowired
    private IProfileRepository profileRepository;


    @Autowired
    private IAccountService accountService;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public Boolean isProfileExistsByCode(String code) {
        return profileRepository.existsById(code);
    }

    @Override
    public Profile getProfileById(String profileCode) {
        return profileRepository.findById(profileCode).orElse(null);
    }

    @Override
    public Page<Profile> getAllProfiles(Pageable pageable, ProfileFilterForm form, String search) {

        Specification<Profile> where = ProfileSpecification.buildWhere(search, form);
        return profileRepository.findAll(where, pageable);
    }

    @Override
    @Transactional
    public Profile createProfile(ProfileCreateForm profileCreateForm) {
        Profile profile = modelMapper.map(profileCreateForm, Profile.class);

        if (profile.getPosition().equals(Profile.Position.Manager)){
            accountService.createAccount(profile);
        }

        return profileRepository.save(profile);
    }

    @Override
    @Transactional
    public Profile updateProfile(ProfileUpdateForm form) {

        // Tìm profile dựa trên profileCode
        Profile profile = getProfileById(form.getProfileCode());

        // Nếu không tìm thấy profile, ném ra ngoại lệ EntityNotFoundException
        if (profile == null) {
            throw new EntityNotFoundException("Không tìm thấy profile có mã: " + form.getProfileCode());
        }

        // Cập nhật các trường nếu không null
        if (form.getBirthday() != null) {
            profile.setBirthday(form.getBirthday());
        }
        if (form.getStatus() != null) {
            profile.setStatus(form.getStatus());
        }
        if (form.getGender() != null) {
            profile.setGender(form.getGender());
        }
        if (form.getFullname() != null) {
            profile.setFullname(form.getFullname());
        }
        if (form.getPhone() != null) {
            profile.setPhone(form.getPhone());
        }
        if (form.getEmail() != null) {
            profile.setEmail(form.getEmail());
        }

        // Cập nhật thời gian chỉnh sửa cuối
        profile.setUpdateAt(LocalDateTime.now());

        // Lưu lại profile đã cập nhật
        return profileRepository.save(profile);
    }

}
