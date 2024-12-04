package SS_BackEnd.Services.ProfileServices;


import SS_BackEnd.Entities.FingerPrint;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.ProfileForms.ProfileCreateForm;
import SS_BackEnd.Forms.ProfileForms.ProfileFilterForm;
import SS_BackEnd.Forms.ProfileForms.ProfileUpdateForm;
import SS_BackEnd.Other.ImageService;
import SS_BackEnd.Repositories.IProfileRepository;
import SS_BackEnd.Services.APIModelService.IModelService;
import SS_BackEnd.Services.AccountServices.IAccountService;
import SS_BackEnd.Services.FingerPrintServices.IFingerPrintService;
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
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

@Service
public class ProfileService implements IProfileService {

    @Autowired
    private IProfileRepository profileRepository;

    @Autowired
    private IFingerPrintService fingerPrintService;


    @Autowired
    private IAccountService accountService;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private IModelService modelService;

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
    public Profile createProfile(ProfileCreateForm profileCreateForm) throws IOException {
        Profile profile = modelMapper.map(profileCreateForm, Profile.class);
        profile = profileRepository.save(profile);

        if (profile.getPosition().equals(Profile.Position.Manager)){
            accountService.createAccount(profile);
        }

        List<MultipartFile> list = new ArrayList<>();
        for (int i=1; i <= profileCreateForm.getImages().size(); i++){
            FingerPrint fingerPrint = fingerPrintService.createFingerPrint(i, profile, profileCreateForm.getImages().get(i-1));
            MultipartFile multipartFile = ImageService.createMultipartFileFromPath(fingerPrint.getPath());
            list.add(multipartFile);
        }

        double bodyResponse;
        int count = 1;
        do{
            bodyResponse = Double.parseDouble( modelService.callAPITraining(profileCreateForm.getImages()) );
            System.err.println("Lần "+ count++ +" " + (int) bodyResponse*100 + "%");

        }while (bodyResponse < 0.6);


        return profile;
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
