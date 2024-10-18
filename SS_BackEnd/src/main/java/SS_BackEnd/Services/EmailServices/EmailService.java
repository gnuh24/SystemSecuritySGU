package SS_BackEnd.Services.EmailServices;

import SS_BackEnd.Entities.CheckIn;
import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Services.ProfileServices.IProfileService;
import jakarta.mail.MessagingException;
import jakarta.mail.internet.MimeMessage;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;

import java.time.format.DateTimeFormatter;


@Service
public class EmailService implements IEmailService {

    @Autowired
    private IProfileService profileService;

    @Autowired
    private JavaMailSender mailSender;

    @Override
    public void sendWarningEmail(CheckIn checkIn) {
        Profile profile = checkIn.getProfile();

        // Define the formatter for the desired time format
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("HH:mm:ss dd/MM/yyyy");

        // Format the shift start time and the actual check-in time
        String shiftTime = checkIn.getShift().getStartTime().format(formatter);
        String lateTime = checkIn.getCheckInTime().format(formatter);
        String shiftName = checkIn.getShift().getShiftName();

        String subject = "Cảnh báo: Đi làm muộn";
        String content = getEmailContentForLateShiftWarning(profile.getFullname(), shiftName, shiftTime, lateTime);

        sendEmail(checkIn.getProfile().getEmail(), subject, content);
    }



    private void sendEmail(final String recipientEmail, final String subject, final String content) {
        MimeMessage message = mailSender.createMimeMessage();
        try {
            MimeMessageHelper helper = new MimeMessageHelper(message, true, "UTF-8");
            helper.setTo(recipientEmail);
            helper.setSubject(subject);
            helper.setText(content, true); // true indicates HTML

            mailSender.send(message);
        } catch (MessagingException e) {
            throw new RuntimeException(e);
        }
    }

    private String getEmailContentForLateShiftWarning(String employeeName, String shiftName, String shiftTime, String lateTime) {
        return "<!DOCTYPE html>" +
            "<html>" +
            "<head>" +
            "<style>" +
            "body {font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;}" +
            ".container {max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; border: 1px solid #ddd; border-radius: 10px;}" +
            ".header {background-color: #ff4d4d; padding: 10px; text-align: center; color: white; border-radius: 10px 10px 0 0;}" +
            ".content {padding: 20px;}" +
            ".content p {margin: 0 0 10px;}" +
            ".footer {margin-top: 20px; text-align: center; color: #888; font-size: 12px;}" +
            ".highlight {color: red; font-weight: bold;}" +
            "</style>" +
            "<script>" +
            "function showWarning() { alert('Đây là cảnh báo về việc đi làm muộn!'); }" +
            "</script>" +
            "</head>" +
            "<body onload=\"showWarning()\">" +
            "<div class=\"container\">" +
            "<div class=\"header\">" +
            "<h1>CẢNH BÁO ĐI LÀM MUỘN</h1>" +
            "</div>" +
            "<div class=\"content\">" +
            "<p>Chào <strong>" + employeeName + "</strong>,</p>" +
            "<p>Chúng tôi phát hiện rằng bạn đã đến muộn trong ca làm việc.</p>" +
            "<p><span class=\"highlight\">Tên ca: " + shiftName + "</span></p>" +
            "<p><span class=\"highlight\">Thời gian ca làm: " + shiftTime + "</span></p>" +
            "<p><span class=\"highlight\">Thời gian bạn đến: " + lateTime + "</span></p>" +
            "<p>Điều này có thể ảnh hưởng đến hiệu quả làm việc của cả đội và dự án. Xin vui lòng tuân thủ quy định về thời gian làm việc trong tương lai.</p>" +
            "</div>" +
            "<div class=\"footer\">" +
            "<p>Cảm ơn bạn đã hiểu và hợp tác!</p>" +
            "<p>Trân trọng,<br>Phòng Nhân sự</p>" +
            "</div>" +
            "</div>" +
            "</body>" +
            "</html>";
    }


}

