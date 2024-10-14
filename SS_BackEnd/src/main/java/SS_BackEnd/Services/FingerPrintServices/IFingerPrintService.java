package SS_BackEnd.Services.FingerPrintServices;

import SS_BackEnd.Entities.FingerPrint;
import SS_BackEnd.Entities.Profile;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.List;

public interface IFingerPrintService {
    List<FingerPrint> getFingerPrintByProfileCode(String profileCode);
    FingerPrint createFingerPrint(Integer stt, Profile profile, MultipartFile image) throws IOException;
}
