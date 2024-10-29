package SS_BackEnd.Services.APIModelService;

import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.List;

public interface IModelService {
    String callAPIRecognition(MultipartFile file) throws IOException ;
    String callAPITraining(List<MultipartFile> files) throws IOException ;
}
