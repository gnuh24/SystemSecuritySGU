package SS_BackEnd.Other;

import org.springframework.web.multipart.MultipartFile;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Objects;

public class ImageService {

    public static final String checkInImage = "src\\main\\java\\SS_BackEnd\\Other\\Images\\CheckInImage";

    public static final String checkOutImage = "src\\main\\java\\SS_BackEnd\\Other\\Images\\CheckOutImage";

    public static final String fingerPrintImage = "src\\main\\java\\SS_BackEnd\\Other\\Images\\FingerPrintImage";

    public static String saveImage(String folderPath, MultipartFile image) throws IOException {

        // Kỹ thuật lấy đường dẫn tuyệt đối (Sử dụng được đối với mọi thiết bị :3 )
        String uploadDir = new File(folderPath).getAbsolutePath();

        Path uploadDirPath = Paths.get(uploadDir);

        // Check if the folder exists
        if (Files.exists(uploadDirPath) && Files.isDirectory(uploadDirPath)) {
            String fileName =  Math.random() + "." + System.currentTimeMillis() +  getFileExtension(Objects.requireNonNull(image.getOriginalFilename()));
            Path uploadPath = Paths.get(uploadDir, fileName);
            Files.write(uploadPath, image.getBytes());
            return fileName;

        } else {
            try {
                //Create if folder isn't exists
                Files.createDirectories(uploadDirPath);
            } catch (IOException e) {
                // Handle the exception, e.g., log the error, provide a fallback, etc.
                System.err.println("Error creating folder: " + e.getMessage());
            }
        }
        return null;
    }

    public static String saveImage(String folderPath, String imageName, MultipartFile image) throws IOException {

        // Kỹ thuật lấy đường dẫn tuyệt đối (Sử dụng được đối với mọi thiết bị :3 )
        String uploadDir = new File(folderPath).getAbsolutePath();

        Path uploadDirPath = Paths.get(uploadDir);

        // Check if the folder exists
        if (Files.exists(uploadDirPath) && Files.isDirectory(uploadDirPath)) {
            String fileName =  imageName +  getFileExtension(Objects.requireNonNull(image.getOriginalFilename()));
            Path uploadPath = Paths.get(uploadDir, fileName);
            Files.write(uploadPath, image.getBytes());
            return fileName;

        } else {
            try {
                //Create if folder isn't exists
                Files.createDirectories(uploadDirPath);
            } catch (IOException e) {
                // Handle the exception, e.g., log the error, provide a fallback, etc.
                System.err.println("Error creating folder: " + e.getMessage());
            }
        }
        return null;
    }

    public static void deleteImage(String folderPath, String imageName) {
        String uploadDir = new File(folderPath).getAbsolutePath();
        Path imagePath = Paths.get(uploadDir, imageName);

        try {
            // Check if the file exists
            if (Files.exists(imagePath)) {
                Files.delete(imagePath);
                System.out.println("Image deleted successfully: " + imageName);
            } else {
                System.out.println("Image not found: " + imageName);
            }
        } catch (IOException e) {
            // Handle the exception, e.g., log the error, provide a fallback, etc.
            System.err.println("Error deleting the image: " + e.getMessage());
        }
    }

    private static String getFileExtension(String fileName) {
        int dotIndex = fileName.lastIndexOf('.');
        if (dotIndex == -1) {
            return "";
        }
        return fileName.substring(dotIndex);
    }



}

