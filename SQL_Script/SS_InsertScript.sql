USE `SGU_SystemSecurity`;

-- Insert sample data into the `Account` table
INSERT INTO `Account` 	(`username`, 	`password`	, 													`role`, `status`) VALUES
						('admin', 		'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', "Admin", true),
						('manager001', 	'$2a$10$W2neF9.6Agi6kAKVq8q3fec5dHW8KUA.b0VSIGdIZyUravfLpyIFi', "Manager", true);

-- Insert sample data into the `Profile` table
INSERT INTO `Profile` 	(`code`, 		`birthday`,    `status`, `createAt`, 				`updateAt`, 				`gender`, 		`fullname`, 		`phone`, 		`email`, 					`accountId`,		`position`) VALUES
						('NV99999999', 	'1985-06-15', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Male',		 	'Mr Bean', 			'123-456-7890', 'john.doe@example.com', 		1,				'Manager'),
						('NV00000001', 	'1990-03-22', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Female', 		'Ngô Tuấn Hưng',	'098-765-4321', 'hungnt.020404@gmail.com', 		NULL,			'Staff'),
						('NV00000002', 	'1988-11-30', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Other', 		'Nguyễn Minh Phúc',	'555-555-5555', 'alice.johnson@example.com', 	NULL,			'Staff'),
						('NV00000003', 	'1985-06-15', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Male', 		'Trương Mậu Điền', 	'123-456-7890', 'john.doe@example.com', 		NULL,			'Staff'),
						('NV00000004', 	'1990-03-22', 	TRUE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Female', 		'Đào Thanh Tú',		'098-765-4321', 'jane.smith@example.com', 		NULL,			'Staff'),
						('NV00000005', 	'1988-11-30', 	FALSE, 	'2024-01-01 08:00:00', 		'2024-01-01 08:00:00', 		'Other', 		'Đoàn Ánh Dương', 	'555-555-5555', 'alice.johnson@example.com', 	NULL,			'Staff');

-- Insert sample data into the `FingerPrint` table
INSERT INTO `FingerPrint` (`profileCode`, `path`, `createAt`) VALUES
							('NV00000001', '/path/to/fingerprint1.jpg', '2024-01-01 08:00:00'),
							('NV00000001', '/path/to/fingerprint2.jpg', '2024-01-01 08:00:00');

-- Insert sample data into the `Shift` table
INSERT INTO `Shift` (`createAt`, `updateAt`, `startTime`, `endTime`, `breakStartTime`, `breakEndTime`, `shiftName`, `isActive`, `isOT`) VALUES
				('2024-01-01 08:00:00', '2024-01-01 08:00:00', '2024-01-01 07:00:00', '2024-01-01 17:30:00', '2024-01-01 12:00:00', '2024-01-01 13:00:00', 'Day Shift', TRUE, FALSE),
				('2024-01-01 08:00:00', '2024-01-01 08:00:00', '2024-01-01 08:00:00', '2024-01-01 16:00:00', '2024-01-01 12:00:00', '2024-01-01 12:30:00', 'Early Shift', TRUE, FALSE);

-- Insert sample data into the `ShiftSignUp` table
INSERT INTO `ShiftSignUp` (`shiftId`, `profileCode`) VALUES
							(1, 'NV00000001'),
							(1, 'NV00000002'),
							(2, 'NV00000001');

-- Insert sample data into the `CheckIn` table
INSERT INTO `CheckIn` (`shiftId`, `profileCode`, `checkInTime`, `createAt`, `Status`, `imgsource`) VALUES
						(1, 'NV00000001', '2024-01-01 07:05:00', '2024-01-01 07:05:00', 'OnTime', '/path/to/checkin1.jpg'),
						(1, 'NV00000002', '2024-01-01 07:10:00', '2024-01-01 07:10:00', 'Late', '/path/to/checkin2.jpg'),
						(2, 'NV00000001', '2024-01-01 08:05:00', '2024-01-01 08:05:00', 'OnTime', '/path/to/checkin3.jpg');

-- Insert sample data into the `CheckOut` table
INSERT INTO `CheckOut` (`shiftId`, `profileCode`, `checkOutTime`, `Status`, `createAt`, `imgsource`) VALUES
						(1, 'NV00000001', '2024-01-01 17:30:00', 'OnTime', '2024-01-01 17:30:00', '/path/to/checkout1.jpg'),
						(1, 'NV00000002', '2024-01-01 17:25:00', 'OnTime', '2024-01-01 17:25:00', '/path/to/checkout2.jpg'),
						(2, 'NV00000001', '2024-01-01 16:00:00', 'LeavingEarly', '2024-01-01 16:00:00', '/path/to/checkout3.jpg');
