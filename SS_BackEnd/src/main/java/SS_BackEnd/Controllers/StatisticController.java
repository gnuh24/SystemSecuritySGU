package SS_BackEnd.Controllers;

import SS_BackEnd.Forms.Other.Response;
import SS_BackEnd.Forms.Query.IProfileWorkSummary;
import SS_BackEnd.Forms.Query.ProfileWorkSummary;
import SS_BackEnd.Forms.Query.ShiftDetailDto;
import SS_BackEnd.Services.StatisticServices.IStatisticService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.time.LocalDate;
import java.util.List;

@RestController
@RequestMapping("/api/Statistic")
public class StatisticController {

    @Autowired
    private IStatisticService statisticService;

    @GetMapping("/ProfileWorkSummary")
    public ResponseEntity<Response<List<IProfileWorkSummary>>> getProfileWorkSummary(
        @RequestParam(required = false) Boolean isOT,
        @RequestParam(required = false) String startDate,
        @RequestParam(required = false) String endDate,
        @RequestParam(required = false) String sort) {

        List<IProfileWorkSummary> entities = statisticService.getProfileWorkSummary(isOT, startDate, endDate, sort);

        // Prepare response
        Response<List<IProfileWorkSummary>> response = new Response<>();
        response.setData(entities);

        String responseMessage = "Thống kê thành công. ";
        if (entities.isEmpty()) {
            responseMessage = "Không có bất cứ thông tin nào để thống kê.";
        }

        response.setStatus(200);
        response.setMessage(responseMessage);
        return ResponseEntity.ok(response);
    }

    @GetMapping("/ShiftDetail")
    public ResponseEntity<Response<List<ShiftDetailDto>>> getShiftDetails(
        @RequestParam String profileCode,
        @RequestParam(required = false) String startDate,
        @RequestParam(required = false) String endDate) {

        List<ShiftDetailDto> entities = statisticService.getShiftDetails(profileCode, startDate, endDate);

        // Prepare response
        Response<List<ShiftDetailDto>> response = new Response<>();
        response.setData(entities);

        String responseMessage = "Thống kê thành công. ";
        if (entities.isEmpty()) {
            responseMessage = "Không có bất cứ thông tin nào để thống kê.";
        }

        response.setStatus(200);
        response.setMessage(responseMessage);
        return ResponseEntity.ok(response);
    }
}
