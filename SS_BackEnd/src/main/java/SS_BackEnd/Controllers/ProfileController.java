package SS_BackEnd.Controllers;

import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Forms.ProfileForms.*;
import SS_BackEnd.Services.IProfileService;
import jakarta.persistence.EntityNotFoundException;
import org.modelmapper.ModelMapper;
import org.modelmapper.TypeToken;
import org.modelmapper.internal.bytebuddy.asm.Advice;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/Profile")
@CrossOrigin(origins = "*")
public class ProfileController {

    @Autowired
    private IProfileService profileService;

    @Autowired
    private ModelMapper modelMapper;

    @GetMapping("/List")
    public ResponseEntity<Response<Page<ProfileDTOListElement>>> getAllProfile(Pageable profile,
                                                                               String search,
                                                                               ProfileFilterForm form) {
        Page<Profile> entities = profileService.getAllProfiles(profile, form, search);

        List<ProfileDTOListElement> dto = modelMapper.map(entities.getContent(), new TypeToken<List<ProfileDTOListElement>>(){} .getType());

        Page<ProfileDTOListElement> dtoPage = new PageImpl<>(dto, profile , entities.getTotalElements());


        Response<Page<ProfileDTOListElement>> response = new Response<>();
        response.setStatus(200);
        response.setMessage("Truy vấn thành công");
        response.setData(dtoPage);

        return ResponseEntity.ok(response);
    }

    @GetMapping("/Detail")
    public ResponseEntity<Response<ProfileDTOInDetail>> getProfileByCode(@RequestParam String code) {
        Profile entities = profileService.getProfileById(code);
        Response<ProfileDTOInDetail> response = new Response<>();

        if (entities != null) {
            ProfileDTOInDetail dto = modelMapper.map(entities, ProfileDTOInDetail.class);

            response.setStatus(200);
            response.setMessage("Truy vấn thành công");
            response.setData(dto);

            return ResponseEntity.ok(response);
        }

        response.setStatus(404);
        response.setMessage("Không tìm thấy thông tin nhân viên có code: " + code);
        response.setData(null);

        return ResponseEntity.status(HttpStatus.NOT_FOUND).body(response);
    }


    @PostMapping("/Create")
    public ResponseEntity<Response<ProfileDTOInDetail>> createProfile(@ModelAttribute ProfileCreateForm profileCreateForm) {
        try {
            Profile createdProfile = profileService.createProfile(profileCreateForm);
            ProfileDTOInDetail dto = modelMapper.map(createdProfile, ProfileDTOInDetail.class);

            Response<ProfileDTOInDetail> response = new Response<>();
            response.setStatus(201);
            response.setMessage("Tạo profile thành công !");
            response.setData(dto);

            return ResponseEntity.status(HttpStatus.CREATED).body(response);
        } catch (Exception e) {
            Response<ProfileDTOInDetail> response = new Response<>();
            response.setStatus(500);
            response.setMessage("Tạo profile thất bại: " + e.getMessage());
            response.setData(null);

            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body(response);
        }
    }

    @PatchMapping("/Update")
    public ResponseEntity<Response<ProfileDTOInDetail>> updateProfile(@ModelAttribute ProfileUpdateForm profileUpdateForm) {
        try {
            // Gọi service để cập nhật profile
            Profile updatedProfile = profileService.updateProfile(profileUpdateForm);
            ProfileDTOInDetail dto = modelMapper.map(updatedProfile, ProfileDTOInDetail.class);

            Response<ProfileDTOInDetail> response = new Response<>();
            response.setStatus(200);
            response.setMessage("Cập nhật profile thành công !");
            response.setData(dto);

            return ResponseEntity.ok(response);
        } catch (EntityNotFoundException e) {
            Response<ProfileDTOInDetail> response = new Response<>();
            response.setStatus(404);
            response.setMessage("Không tìm thấy profile có mã: " + profileUpdateForm.getProfileCode());
            response.setData(null);

            return ResponseEntity.status(HttpStatus.NOT_FOUND).body(response);
        } catch (Exception e) {
            Response<ProfileDTOInDetail> response = new Response<>();
            response.setStatus(500);
            response.setMessage("Cập nhật profile thất bại: " + e.getMessage());
            response.setData(null);

            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body(response);
        }
    }

}

