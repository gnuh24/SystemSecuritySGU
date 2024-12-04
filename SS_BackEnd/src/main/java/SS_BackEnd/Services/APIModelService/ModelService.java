package SS_BackEnd.Services.APIModelService;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.ByteArrayResource;
import org.springframework.core.io.FileSystemResource;
import org.springframework.http.*;
import org.springframework.http.client.MultipartBodyBuilder;
import org.springframework.stereotype.Service;
import org.springframework.util.LinkedMultiValueMap;
import org.springframework.util.MultiValueMap;
import org.springframework.web.client.RestTemplate;
import org.springframework.web.multipart.MultipartFile;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

@Service
public class ModelService implements IModelService {

    @Autowired
    private RestTemplate restTemplate;

    public String callAPIRecognition(MultipartFile file) throws IOException {
        // Convert MultipartFile to File
        File convFile = convertMultipartFileToFile(file);

        // Prepare headers
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.MULTIPART_FORM_DATA);

        // Create the body with file
        MultiValueMap<String, Object> body = new LinkedMultiValueMap<>();
        body.add("file", new FileSystemResource(convFile));

        // Wrap the body and headers into an HttpEntity
        HttpEntity<MultiValueMap<String, Object>> requestEntity = new HttpEntity<>(body, headers);

        // Make the request to the external API
        ResponseEntity<String> response = restTemplate.exchange(
            "http://127.0.0.1:5000/recognize",
            HttpMethod.POST,
            requestEntity,
            String.class
        );

        // Delete temporary file
        convFile.delete();

        // Parse JSON response to get "predicted_label"
        ObjectMapper objectMapper = new ObjectMapper();
        JsonNode jsonNode = objectMapper.readTree(response.getBody());

        return jsonNode.get("predicted_label").asText();
    }

    public String callAPITraining(List<MultipartFile> files) throws IOException {
        // Convert MultipartFile list to File list and prepare resources
        List<File> convertedFiles = new ArrayList<>();
        for (MultipartFile file : files) {
            File convFile = convertMultipartFileToFile(file);
            convertedFiles.add(convFile);
        }

        // Prepare headers
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(MediaType.MULTIPART_FORM_DATA);

        // Create the body with files
        MultiValueMap<String, Object> body = new LinkedMultiValueMap<>();
        for (File file : convertedFiles) {
            body.add("files[]", new FileSystemResource(file));
        }
        System.err.println(body);

        // Wrap the body and headers into an HttpEntity
        HttpEntity<MultiValueMap<String, Object>> requestEntity = new HttpEntity<>(body, headers);

        // Make the request to the external API
        ResponseEntity<String> response = restTemplate.exchange(
            "http://127.0.0.1:5000/train",
            HttpMethod.POST,
            requestEntity,
            String.class
        );

        // Delete temporary files
        for (File file : convertedFiles) {
            file.delete();
        }

        // Process and return the response
        ObjectMapper objectMapper = new ObjectMapper();
        JsonNode jsonNode = objectMapper.readTree(response.getBody()).get("Accuracy");
        System.err.println("Object: " + objectMapper.readTree(response.getBody()).toString());

        // Assuming the API returns a message or status in the response
        return jsonNode.toString();  // Adjust this based on the exact response structure
    }


    // Convert MultipartFile to File
    private File convertMultipartFileToFile(MultipartFile file) throws IOException {
        File convFile = new File(System.getProperty("java.io.tmpdir") + "/" + file.getOriginalFilename());
        try (FileOutputStream fos = new FileOutputStream(convFile)) {
            fos.write(file.getBytes());
        }
        return convFile;
    }
}
