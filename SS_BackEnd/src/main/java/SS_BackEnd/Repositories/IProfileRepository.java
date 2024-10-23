package SS_BackEnd.Repositories;

import SS_BackEnd.Entities.Profile;
import SS_BackEnd.Forms.Query.IProfileWorkSummary;
import SS_BackEnd.Forms.Query.ProfileWorkSummary;
import SS_BackEnd.Forms.Query.ShiftDetailDto;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import java.time.LocalDate;
import java.util.List;

public interface IProfileRepository extends JpaRepository<Profile, String>, JpaSpecificationExecutor<Profile> {

    @Query(value = """
            SELECT
                p.code AS ProfileCode,
                p.fullname AS ProfileName,
                COALESCE(ROUND(SUM(
                    CASE
                        WHEN s.isOT = FALSE AND ci.Status = 'OnTime' AND co.Status = 'OnTime' THEN
                            TIMESTAMPDIFF(MINUTE, s.startTime, s.endTime) / 60.0
                        WHEN s.isOT = FALSE AND ci.Status = 'OnTime' AND co.Status = 'LeavingEarly' THEN
                            TIMESTAMPDIFF(MINUTE, s.startTime, co.checkOutTime) / 60.0
                        WHEN s.isOT = FALSE AND ci.Status = 'Late' AND co.Status = 'OnTime' THEN
                            TIMESTAMPDIFF(MINUTE, ci.checkInTime, s.endTime) / 60.0
                        WHEN s.isOT = FALSE AND ci.Status = 'Late' AND co.Status = 'LeavingEarly' THEN
                            TIMESTAMPDIFF(MINUTE, ci.checkInTime, co.checkOutTime) / 60.0
                    END
                ), 2), 0) AS TotalHoursWorkedOfficial,
                COALESCE(ROUND(SUM(
                    CASE
                        WHEN s.isOT = TRUE AND ci.Status = 'OnTime' AND co.Status = 'OnTime' THEN
                            TIMESTAMPDIFF(MINUTE, s.startTime, s.endTime) / 60.0
                        WHEN s.isOT = TRUE AND ci.Status = 'OnTime' AND co.Status = 'LeavingEarly' THEN
                            TIMESTAMPDIFF(MINUTE, s.startTime, co.checkOutTime) / 60.0
                        WHEN s.isOT = TRUE AND ci.Status = 'Late' AND co.Status = 'OnTime' THEN
                            TIMESTAMPDIFF(MINUTE, ci.checkInTime, s.endTime) / 60.0
                        WHEN s.isOT = TRUE AND ci.Status = 'Late' AND co.Status = 'LeavingEarly' THEN
                            TIMESTAMPDIFF(MINUTE, ci.checkInTime, co.checkOutTime) / 60.0
                    END
                ), 2), 0) AS TotalHoursWorkedOT,
                COALESCE(SUM(
                    CASE
                        WHEN ci.Status = 'Late' THEN
                            TIMESTAMPDIFF(MINUTE, s.startTime, ci.checkInTime)
                        ELSE 0
                    END
                ), 0) AS TotalMinutesLate,
                COALESCE(SUM(
                    CASE
                        WHEN co.Status = 'LeavingEarly' THEN
                            TIMESTAMPDIFF(MINUTE, co.checkOutTime, s.endTime)
                        ELSE 0
                    END
                ), 0) AS TotalMinutesLeavingEarly,
                COALESCE(COUNT(DISTINCT ss.shiftId), 0) AS TotalShiftSignUp,
                COALESCE(COUNT(ci.checkInTime), 0) AS TotalWorkingShift,
                COALESCE(COUNT(DISTINCT ss.shiftId), 0) - COALESCE(COUNT(DISTINCT CASE WHEN ci.checkInTime IS NOT NULL THEN s.id END), 0) AS TotalDaysNotWorked
            FROM
                Profile p
            LEFT JOIN
                ShiftSignUp ss ON p.code = ss.profileCode
            LEFT JOIN
                Shift s ON ss.shiftId = s.id AND s.isActive = TRUE
            LEFT JOIN
                CheckIn ci ON ss.shiftId = ci.shiftId AND ss.profileCode = ci.profileCode
            LEFT JOIN
                CheckOut co ON ci.shiftId = co.shiftId AND ci.profileCode = co.profileCode
            WHERE
                s.isActive = TRUE
                AND (:isOT IS NULL OR s.isOT = :isOT)
                AND DATE(s.startTime) >= COALESCE(:startDate, DATE_FORMAT(NOW(), '%Y-%m-01'))
                AND DATE(s.endTime) <= COALESCE(:endDate, LAST_DAY(NOW()))
            GROUP BY
                p.code, p.fullname
            ORDER BY TotalHoursWorkedOfficial DESC;
            """, nativeQuery = true)
    List<IProfileWorkSummary> getProfileStatistics(@Param("isOT") Boolean isOT,
            @Param("startDate") String startDate,
            @Param("endDate") String endDate);

    @Query(value = """
            SELECT
                p.code AS ProfileCode,
                p.fullname AS ProfileName,
                s.id AS ShiftId,
                s.startTime AS ShiftStartTime,
                s.endTime AS ShiftEndTime,
                s.isOT AS IsOvertime,
                ci.checkInTime AS CheckInTime,
                ci.Status AS CheckInStatus,
                co.checkOutTime AS CheckOutTime,
                co.Status AS CheckOutStatus
            FROM
                Profile p
            LEFT JOIN
                ShiftSignUp ss ON p.code = ss.profileCode
            LEFT JOIN
                Shift s ON ss.shiftId = s.id AND s.isActive = TRUE
            LEFT JOIN
                CheckIn ci ON ss.shiftId = ci.shiftId AND ss.profileCode = ci.profileCode
            LEFT JOIN
                CheckOut co ON ci.shiftId = co.shiftId AND ci.profileCode = co.profileCode
            WHERE
                s.isActive = TRUE
                AND p.code = :profileCode
                AND DATE(s.startTime) >= COALESCE(:startDate, DATE_FORMAT(NOW(), '%Y-%m-01'))
                AND DATE(s.endTime) <= COALESCE(:endDate, LAST_DAY(NOW()))
            ORDER BY
                s.startTime
            """, nativeQuery = true)
    List<ShiftDetailDto> getShiftDetailsByProfileCode(
            @Param("profileCode") String profileCode,
            @Param("startDate") String startDate,
            @Param("endDate") String endDate);
}
