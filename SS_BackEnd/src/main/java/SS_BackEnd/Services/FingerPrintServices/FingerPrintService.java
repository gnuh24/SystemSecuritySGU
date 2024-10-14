package SS_BackEnd.Services.FingerPrintServices;

import SS_BackEnd.Entities.FingerPrint;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Other.ImageService;
import SS_BackEnd.Repositories.IFingerPrintRepository;
import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.List;

@Service
public class FingerPrintService implements IFingerPrintService {

    @Autowired
    private IFingerPrintRepository fingerPrintRepository;

    @Autowired
    private ModelMapper modelMapper;

    @Override
    public List<FingerPrint> getFingerPrintByProfileCode(String profileCode) {
        return fingerPrintRepository.findByProfileCode(profileCode);
    }

    @Override
    public FingerPrint createFingerPrint(Integer stt, Profile profile, MultipartFile image) throws IOException {
        FingerPrint fingerPrint = new FingerPrint();

        FingerPrint.FingerPrintId id = new FingerPrint.FingerPrintId();
        id.setProfileCode(profile.getCode());
        String imageName = profile.getCode() + "_" + stt;
        id.setImageName(imageName);
        fingerPrint.setId(id);

        String path = ImageService.saveImage(ImageService.fingerPrintImage, imageName, image) ;
        fingerPrint.setPath(path);

        return fingerPrintRepository.save(fingerPrint);
    }
}