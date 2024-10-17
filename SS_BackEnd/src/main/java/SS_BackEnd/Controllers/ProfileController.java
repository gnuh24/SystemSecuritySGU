package SS_BackEnd.Controllers;

import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Forms.ProfileForms.*;
import SS_BackEnd.Services.ProfileServices.IProfileService;
import jakarta.persistence.EntityNotFoundException;
import jakarta.validation.Valid;
import lombok.extern.slf4j.Slf4j;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.io.IOException;
import java.util.List;

@RestController
@RequestMapping("/api/Profile")
@Slf4j
public class ProfileController {

    @Autowired
    private IProfileService profileService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping("/List")
    public ResponseEntity<Response<Page<ProfileDTOListElement>>> getAllProfile(Pageable profile,
                                                                               @RequestParam(required = false) String search,
                                                                               ProfileFilterForm form) {
        Page<Profile> entities = profileService.getAllProfiles(profile, form, search);
        List<ProfileDTOListElement> dto = modelMapper.map(entities.getContent(), new TypeToken<List<ProfileDTOListElement>>(){} .getType());
        Page<ProfileDTOListElement> dtoPage = new PageImpl<>(dto, profile , entities.getTotalElements());

        Response<Page<ProfileDTOListElement>> response = new Response<>();
        response.setData(dtoPage);
        String reponseMessage = "Truy ấn thành công";


        if (dto.isEmpty()){
            reponseMessage = "Không tìm thấy bất cứ Profile nào theo yêu cầu !!";
        }
        log.info(reponseMessage);
        response.setStatus(200);
        response.setMessage(reponseMessage);
        return ResponseEntity.ok(response);
    }

    @GetMapping("/Detail")
    public ResponseEntity<Response<ProfileDTOInDetail>> getProfileByCode(@RequestParam String code) {
        Profile entities = profileService.getProfileById(code);
        Response<ProfileDTOInDetail> response = new Response<>();

        if (entities == null) {
            throw new EntityNotFoundException("Không tìm thấy thông tin nhân viên có code: " + code);
        }

        ProfileDTOInDetail dto = modelMapper.map(entities, ProfileDTOInDetail.class);
        response.setStatus(200);
        response.setMessage("Truy vấn thành công");
        response.setData(dto);
        return ResponseEntity.ok(response);
    }


    @PostMapping("/Create")
    public ResponseEntity<Response<ProfileDTOInDetail>> createProfile(@ModelAttribute @Valid ProfileCreateForm profileCreateForm) throws IOException {
            Profile createdProfile = profileService.createProfile(profileCreateForm);
            ProfileDTOInDetail dto = modelMapper.map(createdProfile, ProfileDTOInDetail.class);

            Response<ProfileDTOInDetail> response = new Response<>();
            response.setStatus(201);
            response.setMessage("Tạo profile thành công !");
            response.setData(dto);

            return ResponseEntity.status(HttpStatus.CREATED).body(response);

    }

    @PatchMapping("/Update")
    public ResponseEntity<Response<ProfileDTOInDetail>> updateProfile(@ModelAttribute @Valid ProfileUpdateForm profileUpdateForm) {
            // Gọi service để cập nhật profile
            Profile updatedProfile = profileService.updateProfile(profileUpdateForm);
            ProfileDTOInDetail dto = modelMapper.map(updatedProfile, ProfileDTOInDetail.class);

            Response<ProfileDTOInDetail> response = new Response<>();
            response.setStatus(200);
            response.setMessage("Cập nhật profile thành công !");
            response.setData(dto);

            return ResponseEntity.ok(response);

    }

}

