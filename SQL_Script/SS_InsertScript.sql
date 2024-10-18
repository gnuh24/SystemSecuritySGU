USE `SGU_SystemSecurity`;

-- Insert sample data into the `Account` table
INSERT INTO `Account` 	(`username`, 	`password`	, 													`role`, `status`) VALUES
						('admin', 		'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', "Admin", true),
						('manager001', 	'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', "Manager", true);

-- Insert sample data into the `Profile` table
INSERT INTO `Profile` 	(`code`, 		`birthday`,    `status`, `createAt`, 				`updateAt`, 				`gender`, 		`fullname`, 		`phone`, 		`email`, 					`accountId`,		`position`) VALUES
						('NV99999998', 	'1985-06-15', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Male',		 	'Mr Admin', 		'123-456-7890', 'admin@example.com', 			1,				'Manager'),
                        ('NV99999999', 	'1985-06-15', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Male',		 	'Mr Bean', 			'123-456-7890', 'john.doe@example.com', 		2,				'Manager'),
						('NV00000001', 	'1990-03-22', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Female', 		'Ngô Tuấn Hưng',	'098-765-4321', 'hungnt.020404@gmail.com', 		NULL,			'Employee'),
						('NV00000002', 	'1988-11-30', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Other', 		'Nguyễn Minh Phúc',	'555-555-5555', 'alice.johnson@example.com', 	NULL,			'Employee'),
						('NV00000003', 	'1985-06-15', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Male', 		'Trương Mậu Điền', 	'123-456-7890', 'john.doe@example.com', 		NULL,			'Employee'),
						('NV00000004', 	'1990-03-22', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Female', 		'Đào Thanh Tú',		'098-765-4321', 'jane.smith@example.com', 		NULL,			'Employee'),
						('NV00000005', 	'1988-11-30', 	FALSE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Other', 		'Đoàn Ánh Dương', 	'555-555-5555', 'alice.johnson@example.com', 	NULL,			'Employee');

-- Insert sample data into the `FingerPrint` table
INSERT INTO `FingerPrint` (`profileCode`, `imageName`,`path`, `createAt`) VALUES
							('NV00000001','1_1' ,'/path/to/fingerprint1.jpg', '2024-01-01 08:00:00'),
							('NV00000001', '1_2','/path/to/fingerprint2.jpg', '2024-01-01 08:00:00');

-- Insert 10 sample shifts from August 2024 to December 2024
INSERT INTO `Shift` (`createAt`, 			`updateAt`, 			`startTime`, 			`endTime`, 			`breakStartTime`,		 `breakEndTime`,		`shiftName`, 	`isActive`, `isOT`) VALUES
					('2024-08-01 08:00:00', '2024-08-01 08:00:00', '2024-08-01 07:00:00', '2024-08-01 16:30:00', '2024-08-01 12:00:00', '2024-08-01 13:00:00', 'Morning Shift', 	TRUE, FALSE),
					('2024-08-15 08:00:00', '2024-08-15 08:00:00', '2024-08-15 14:00:00', '2024-08-15 22:00:00', '2024-08-15 18:00:00', '2024-08-15 18:30:00', 'Afternoon Shift', 	TRUE, FALSE),
					('2024-09-01 08:00:00', '2024-09-01 08:00:00', '2024-09-01 09:00:00', '2024-09-01 17:30:00', '2024-09-01 12:00:00', '2024-09-01 13:00:00', 'Day Shift', TRUE, FALSE),
					('2024-09-10 08:00:00', '2024-09-10 08:00:00', '2024-09-10 07:00:00', '2024-09-10 15:00:00', '2024-09-10 11:30:00', '2024-09-10 12:30:00', 'Early Shift', TRUE, FALSE),
					('2024-10-05 08:00:00', '2024-10-05 08:00:00', '2024-10-05 22:00:00', '2024-10-06 06:00:00', '2024-10-06 02:00:00', '2024-10-06 02:30:00', 'Night Shift', TRUE, TRUE),
					('2024-10-20 08:00:00', '2024-10-20 08:00:00', '2024-10-20 14:00:00', '2024-10-20 22:00:00', '2024-10-20 18:00:00', '2024-10-20 18:30:00', 'Afternoon Shift', TRUE, FALSE),
					('2024-11-01 08:00:00', '2024-11-01 08:00:00', '2024-11-01 07:00:00', '2024-11-01 17:30:00', '2024-11-01 12:00:00', '2024-11-01 13:00:00', 'Day Shift', TRUE, FALSE),
					('2024-11-10 08:00:00', '2024-11-10 08:00:00', '2024-11-10 09:00:00', '2024-11-10 18:00:00', '2024-11-10 13:00:00', '2024-11-10 14:00:00', 'Extended Shift', TRUE, TRUE),
					('2024-12-01 08:00:00', '2024-12-01 08:00:00', '2024-12-01 08:00:00', '2024-12-01 16:00:00', '2024-12-01 12:00:00', '2024-12-01 12:30:00', 'Early Shift', TRUE, FALSE),
					('2024-12-15 08:00:00', '2024-12-15 08:00:00', '2024-12-15 22:00:00', '2024-12-16 06:00:00', '2024-12-16 02:00:00', '2024-12-16 02:30:00', 'Night Shift', TRUE, TRUE);



-- Insert sample data into the `ShiftSignUp` table
-- Insert all employees into all shifts
INSERT INTO `ShiftSignUp` (`shiftId`, `profileCode`, `signUpTime`) VALUES
    -- NV00000001 đăng ký vào tất cả các ca
    (1, 'NV00000001', NOW()),
    (2, 'NV00000001', NOW()),
    (3, 'NV00000001', NOW()),
    (4, 'NV00000001', NOW()),
    (5, 'NV00000001', NOW()),
    (6, 'NV00000001', NOW()),
    (7, 'NV00000001', NOW()),
    (8, 'NV00000001', NOW()),
    (9, 'NV00000001', NOW()),
    (10, 'NV00000001', NOW()),
    
    -- NV00000002 đăng ký vào tất cả các ca
    (1, 'NV00000002', NOW()),
    (2, 'NV00000002', NOW()),
    (3, 'NV00000002', NOW()),
    (4, 'NV00000002', NOW()),
    (5, 'NV00000002', NOW()),
    (6, 'NV00000002', NOW()),
    (7, 'NV00000002', NOW()),
    (8, 'NV00000002', NOW()),
    (9, 'NV00000002', NOW()),
    (10, 'NV00000002', NOW()),
    
    -- NV00000003 đăng ký vào tất cả các ca
    (1, 'NV00000003', NOW()),
    (2, 'NV00000003', NOW()),
    (3, 'NV00000003', NOW()),
    (4, 'NV00000003', NOW()),
    (5, 'NV00000003', NOW()),
    (6, 'NV00000003', NOW()),
    (7, 'NV00000003', NOW()),
    (8, 'NV00000003', NOW()),
    (9, 'NV00000003', NOW()),
    (10, 'NV00000003', NOW()),
    
    -- NV00000004 đăng ký vào tất cả các ca
    (1, 'NV00000004', NOW()),
    (2, 'NV00000004', NOW()),
    (3, 'NV00000004', NOW()),
    (4, 'NV00000004', NOW()),
    (5, 'NV00000004', NOW()),
    (6, 'NV00000004', NOW()),
    (7, 'NV00000004', NOW()),
    (8, 'NV00000004', NOW()),
    (9, 'NV00000004', NOW()),
    (10, 'NV00000004', NOW()),
    
    -- NV00000005 đăng ký vào tất cả các ca
    (1, 'NV00000005', NOW()),
    (2, 'NV00000005', NOW()),
    (3, 'NV00000005', NOW()),
    (4, 'NV00000005', NOW()),
    (5, 'NV00000005', NOW()),
    (6, 'NV00000005', NOW()),
    (7, 'NV00000005', NOW()),
    (8, 'NV00000005', NOW()),
    (9, 'NV00000005', NOW()),
    (10, 'NV00000005', NOW()),
    
    -- NV99999999 đăng ký vào tất cả các ca
    (1, 'NV99999999', NOW()),
    (2, 'NV99999999', NOW()),
    (3, 'NV99999999', NOW()),
    (4, 'NV99999999', NOW()),
    (5, 'NV99999999', NOW()),
    (6, 'NV99999999', NOW()),
    (7, 'NV99999999', NOW()),
    (8, 'NV99999999', NOW()),
    (9, 'NV99999999', NOW()),
    (10, 'NV99999999', NOW());


-- Insert sample data into the `CheckIn` table
-- Insert sample data into the `CheckIn` table
INSERT INTO `CheckIn` (`shiftId`, `profileCode`, `checkInTime`, `Status`, `image`) VALUES
					(1, 'NV00000001', '2024-08-01 07:05:00',  'OnTime', '/path/to/checkin1.jpg'),
					(1, 'NV00000002', '2024-08-01 07:10:00', 'Late', '/path/to/checkin2.jpg'),
					(2, 'NV00000001', '2024-08-02 08:05:00', 'OnTime', '/path/to/checkin3.jpg'),
					(3, 'NV00000003', '2024-08-03 07:00:00', 'OnTime', '/path/to/checkin4.jpg'),
					(4, 'NV00000004', '2024-08-03 07:15:00', 'Late', '/path/to/checkin5.jpg'),
					(5, 'NV00000005', '2024-08-04 07:05:00', 'OnTime', '/path/to/checkin6.jpg'),
					(6, 'NV99999999', '2024-08-04 07:20:00', 'Late', '/path/to/checkin7.jpg'),
					(7, 'NV00000001', '2024-08-05 07:00:00', 'OnTime', '/path/to/checkin8.jpg'),
					(8, 'NV00000002', '2024-08-05 07:10:00', 'Late', '/path/to/checkin9.jpg'),
					(9, 'NV00000003', '2024-08-06 07:05:00', 'OnTime', '/path/to/checkin10.jpg');
                    -- Insert more sample data into the `CheckIn` table
INSERT INTO `CheckIn` (`shiftId`, `profileCode`, `checkInTime`, `Status`, `image`) VALUES
					(1, 'NV00000003', '2024-08-01 07:02:00', 'OnTime', '/path/to/checkin11.jpg'),
					(2, 'NV00000004', '2024-08-01 08:10:00', 'Late', '/path/to/checkin12.jpg'),
					(3, 'NV00000005', '2024-08-02 07:00:00', 'OnTime', '/path/to/checkin13.jpg'),
					(4, 'NV99999999', '2024-08-02 07:20:00', 'Late', '/path/to/checkin14.jpg'),
					(5, 'NV00000001', '2024-08-03 07:05:00', 'OnTime', '/path/to/checkin15.jpg'),
					(6, 'NV00000002', '2024-08-03 07:12:00', 'Late', '/path/to/checkin16.jpg'),
					(7, 'NV00000003', '2024-08-04 07:03:00', 'OnTime', '/path/to/checkin17.jpg'),
					(8, 'NV00000004', '2024-08-04 07:18:00', 'Late', '/path/to/checkin18.jpg'),
					(9, 'NV00000005', '2024-08-05 07:07:00', 'OnTime', '/path/to/checkin19.jpg'),
					(10, 'NV99999999', '2024-08-05 07:22:00', 'Late', '/path/to/checkin20.jpg');



						-- Insert sample data into the `CheckOut` table
INSERT INTO `CheckOut` (`shiftId`, `profileCode`, `checkOutTime`, `Status`, `image`) VALUES
						(1, 'NV00000001', '2024-08-01 17:30:00', 'OnTime', '/path/to/checkout1.jpg'),
						(1, 'NV00000002', '2024-08-01 17:25:00', 'OnTime', '/path/to/checkout2.jpg'),
						(2, 'NV00000001', '2024-08-02 16:00:00', 'LeavingEarly', '/path/to/checkout3.jpg'),
						(3, 'NV00000003', '2024-08-03 17:30:00', 'OnTime', '/path/to/checkout4.jpg'),
						(4, 'NV00000004', '2024-08-03 17:20:00', 'OnTime', '/path/to/checkout5.jpg'),
						(5, 'NV00000005', '2024-08-04 17:30:00', 'OnTime', '/path/to/checkout6.jpg'),
						(6, 'NV99999999', '2024-08-04 17:15:00', 'OnTime', '/path/to/checkout7.jpg'),
						(7, 'NV00000001', '2024-08-05 17:30:00', 'OnTime', '/path/to/checkout8.jpg'),
						(8, 'NV00000002', '2024-08-05 17:25:00', 'OnTime', '/path/to/checkout9.jpg'),
						(9, 'NV00000003', '2024-08-06 17:30:00', 'OnTime', '/path/to/checkout10.jpg');
                        
                        -- Insert more sample data into the `CheckOut` table
INSERT INTO `CheckOut` (`shiftId`, `profileCode`, `checkOutTime`, `Status`, `image`) VALUES
					(1, 'NV00000003', '2024-08-01 17:30:00', 'OnTime', '/path/to/checkout11.jpg'),
					(2, 'NV00000004', '2024-08-01 16:30:00', 'LeavingEarly', '/path/to/checkout12.jpg'),
					(3, 'NV00000005', '2024-08-02 17:30:00', 'OnTime', '/path/to/checkout13.jpg'),
					(4, 'NV99999999', '2024-08-02 17:15:00', 'OnTime', '/path/to/checkout14.jpg'),
					(5, 'NV00000001', '2024-08-03 17:30:00', 'OnTime', '/path/to/checkout15.jpg'),
					(6, 'NV00000002', '2024-08-03 17:25:00', 'OnTime', '/path/to/checkout16.jpg'),
					(7, 'NV00000003', '2024-08-04 17:30:00', 'OnTime', '/path/to/checkout17.jpg'),
					(8, 'NV00000004', '2024-08-04 17:20:00', 'OnTime', '/path/to/checkout18.jpg'),
					(9, 'NV00000005', '2024-08-05 17:30:00', 'OnTime', '/path/to/checkout19.jpg'),
					(10, 'NV99999999', '2024-08-05 17:10:00', 'LeavingEarly', '/path/to/checkout20.jpg');


