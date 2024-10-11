package SS_BackEnd.Forms.Shift;

import SS_BackEnd.Forms.CheckIn.CheckInDTOForCreateCheckIn;
import SS_BackEnd.Forms.ShiftSignUp.ShiftSignUpDTOForShiftDTOInDetail;
import com.fasterxml.jackson.annotation.JsonFormat;
import lombok.Data;

import java.time.LocalDateTime;
import java.util.List;

@Data
public class ShiftDTOInDetail {

    private Integer id;

    private String shiftName;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime createAt ;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime updateAt ;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime startTime;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime endTime;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime breakStartTime;

    @JsonFormat(pattern = "HH:mm:ss dd/MM/yyyy")
    private LocalDateTime breakEndTime;

    private Boolean isActive;

    private Boolean isOT;

    private List<ShiftSignUpDTOForShiftDTOInDetail> signUps;

    private List<CheckInDTOForCreateCheckIn> checkIns;

}
