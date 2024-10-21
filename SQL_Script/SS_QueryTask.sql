USE `SGU_SystemSecurity`;

-- 1. Thống kê tổng quát
SELECT
    p.code AS ProfileCode,
    p.fullname AS ProfileName,

    -- Calculate total official hours worked
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

    -- Calculate total overtime hours worked
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

    -- Calculate total minutes late
    COALESCE(SUM(
        CASE
            WHEN ci.Status = 'Late' THEN
                TIMESTAMPDIFF(MINUTE, s.startTime, ci.checkInTime)
            ELSE 0
        END
    ), 0) AS TotalMinutesLate,

    -- Calculate total minutes leaving early
    COALESCE(SUM(
        CASE
            WHEN co.Status = 'LeavingEarly' THEN
                TIMESTAMPDIFF(MINUTE, co.checkOutTime, s.endTime)
            ELSE 0
        END
    ), 0) AS TotalMinutesLeavingEarly,

    -- Count total shifts signed up for
    COALESCE(COUNT(DISTINCT ss.shiftId), 0) AS TotalShiftSignUp,

    -- Count total working shifts
    COALESCE(COUNT(ci.checkInTime), 0) AS TotalWorkingShift,

    -- Calculate the number of days not worked
    COALESCE(COUNT(DISTINCT ss.shiftId), 0) - COALESCE(COUNT(DISTINCT CASE WHEN ci.checkInTime IS NOT NULL THEN s.id END), 0) AS TotalDaysNotWorked

FROM
    Profile p
LEFT JOIN
    ShiftSignUp ss ON p.code = ss.profileCode
LEFT JOIN
    Shift s ON ss.shiftId = s.id AND s.isActive = true
LEFT JOIN
    CheckIn ci ON ss.shiftId = ci.shiftId AND ss.profileCode = ci.profileCode
LEFT JOIN
    CheckOut co ON ci.shiftId = co.shiftId AND ci.profileCode = co.profileCode

WHERE
    s.`isActive` = true
    AND (:isOT IS NULL OR s.isOT = :isOT)  
    AND DATE(s.startTime) >= COALESCE(:startDate, DATE_FORMAT(NOW(), '%Y-%m-01'))
    AND DATE(s.endTime) <= COALESCE(:endDate, LAST_DAY(NOW()))
GROUP BY
    p.code, p.fullname;

-- ORDER BY
--     CASE 
--         WHEN :sort IS NULL THEN TotalHoursWorkedOfficial  -- Default sorting
--         WHEN :sort = 'profileCode' THEN p.code
--         WHEN :sort = 'profileCode,desc' THEN p.code DESC
--         WHEN :sort = 'profileName' THEN p.fullname
--         WHEN :sort = 'profileName,desc' THEN p.fullname DESC
--         WHEN :sort = 'TotalHoursWorkedOfficial' THEN TotalHoursWorkedOfficial
--         WHEN :sort = 'TotalHoursWorkedOfficial,desc' THEN TotalHoursWorkedOfficial DESC
--         WHEN :sort = 'TotalHoursWorkedOT' THEN TotalHoursWorkedOT
--         WHEN :sort = 'TotalHoursWorkedOT,desc' THEN TotalHoursWorkedOT DESC
--         WHEN :sort = 'TotalMinutesLate' THEN TotalMinutesLate
--         WHEN :sort = 'TotalMinutesLate,desc' THEN TotalMinutesLate DESC
--         WHEN :sort = 'TotalMinutesLeavingEarly' THEN TotalMinutesLeavingEarly
--         WHEN :sort = 'TotalMinutesLeavingEarly,desc' THEN TotalMinutesLeavingEarly DESC
--         WHEN :sort = 'TotalShiftSignUp' THEN TotalShiftSignUp
--         WHEN :sort = 'TotalShiftSignUp,desc' THEN TotalShiftSignUp DESC
--         WHEN :sort = 'TotalWorkingShift' THEN TotalWorkingShift
--         WHEN :sort = 'TotalWorkingShift,desc' THEN TotalWorkingShift DESC
--         WHEN :sort = 'TotalDaysNotWorked' THEN TotalDaysNotWorked
--         WHEN :sort = 'TotalDaysNotWorked,desc' THEN TotalDaysNotWorked DESC
--         ELSE TotalHoursWorkedOfficial  -- Default sorting if the sort param is not valid
--     END


-- 2. Thông tin chi tiết
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
    Shift s ON ss.shiftId = s.id 
LEFT JOIN 
    CheckIn ci ON ss.shiftId = ci.shiftId AND ss.profileCode = ci.profileCode
LEFT JOIN 
    CheckOut co ON ci.shiftId = co.shiftId AND ci.profileCode = co.profileCode
WHERE 
	s.`isActive` = true
    AND p.code = :profileCode
	AND DATE(s.startTime) >= COALESCE(:startDate, DATE_FORMAT(NOW(), '%Y-%m-01'))
    AND DATE(s.endTime) <= COALESCE(:endDate, LAST_DAY(NOW()))
ORDER BY 
    s.startTime;


