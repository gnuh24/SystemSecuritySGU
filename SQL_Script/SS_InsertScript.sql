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
INSERT INTO `Shift` (`createAt`, 			`updateAt`, 			`startTime`, 			`endTime`, 			`breakStartTime`,		 `breakEndTime`,		`shiftName`, 						`isActive`, 	`isOT`) VALUES
					('2024-08-01 08:00:00', '2024-08-01 08:00:00', '2024-08-01 07:00:00', '2024-08-01 17:30:00', '2024-08-01 11:30:00', '2024-08-01 13:00:00', 'Ca chính thức 01/08/2024', 			FALSE, 			FALSE),
					('2024-08-15 08:00:00', '2024-08-15 08:00:00', '2024-08-15 07:00:00', '2024-08-15 17:30:00', '2024-08-15 11:30:00', '2024-08-15 13:00:00', 'Ca chính thức 15/08/2024', 			TRUE, 			FALSE),
					('2024-09-01 08:00:00', '2024-09-01 08:00:00', '2024-09-01 07:00:00', '2024-09-01 17:30:00', '2024-09-01 11:30:00', '2024-09-01 13:00:00', 'Ca chính thức 01/09/2024', 			TRUE, 			FALSE),
					('2024-09-10 08:00:00', '2024-09-10 08:00:00', '2024-09-10 07:00:00', '2024-09-10 17:30:00', '2024-09-10 11:30:00', '2024-09-10 13:00:00', 'Ca chính thức 10/09/2024', 			TRUE, 			FALSE),
					('2024-10-05 08:00:00', '2024-10-05 08:00:00', '2024-10-05 07:00:00', '2024-10-05 17:30:00', '2024-10-05 11:30:00', '2024-10-05 13:00:00', 'Ca chính thức 05/10/2024', 			TRUE, 			FALSE),
					('2024-10-05 08:00:00', '2024-10-05 08:00:00', '2024-10-05 18:00:00', '2024-10-05 21:30:00', 				  NULL, 				 NULL, 'OT 05/10/2024', 					TRUE, 			TRUE),
					('2024-11-29 08:00:00', '2024-11-29 08:00:00', '2024-11-29 07:00:00', '2024-11-29 17:30:00', '2024-11-29 11:30:00', '2024-11-29 13:00:00', 'Ca chính thức 29/10/2024', 			TRUE, 			FALSE);


-- Insert sample data into the `ShiftSignUp` table
-- Insert all employees into all shifts
INSERT INTO `ShiftSignUp` (`shiftId`, `profileCode`, `signUpTime`) VALUES
    -- NV00000001 đăng ký vào tất cả các ca
    (1, 'NV00000001', NOW()),
    (2, 'NV00000001', NOW()),
    (3, 'NV00000001', NOW()),
    (4, 'NV00000001', NOW()),
    (5, 'NV00000001', NOW()),
    
    -- NV00000002 đăng ký vào tất cả các ca
    (1, 'NV00000002', NOW()),
    (2, 'NV00000002', NOW()),
    (3, 'NV00000002', NOW()),
    (4, 'NV00000002', NOW()),
    (5, 'NV00000002', NOW()),
    
    -- NV00000003 đăng ký vào tất cả các ca
    (1, 'NV00000003', NOW()),
    (2, 'NV00000003', NOW()),
    (3, 'NV00000003', NOW()),
    (4, 'NV00000003', NOW()),
    (5, 'NV00000003', NOW()),
    
    -- NV00000004 đăng ký vào tất cả các ca
    (1, 'NV00000004', NOW()),
    (2, 'NV00000004', NOW()),
    (3, 'NV00000004', NOW()),
    (4, 'NV00000004', NOW()),
    (5, 'NV00000004', NOW()),
    
    -- NV00000005 đăng ký vào tất cả các ca
    (1, 'NV00000005', NOW()),
    (2, 'NV00000005', NOW()),
    (3, 'NV00000005', NOW()),
    (4, 'NV00000005', NOW()),
    (5, 'NV00000005', NOW()),
    
	(6, 'NV00000001', NOW()),
    (6, 'NV00000002', NOW()),
    
	-- NV00000005 đăng ký vào tất cả các ca
    (7, 'NV00000001', NOW()),
    (7, 'NV00000002', NOW()),
    (7, 'NV00000003', NOW()),
    (7, 'NV00000004', NOW()),
    (7, 'NV00000005', NOW());


-- Insert sample data into the `CheckIn` table
INSERT INTO `CheckIn` (`shiftId`, `profileCode`, `checkInTime`, `Status`, 		`image`) VALUES
					(1, 'NV00000001', '2024-08-01 06:05:00',  'OnTime',  		'/path/to/checkin1.jpg'),
					(1, 'NV00000002', '2024-08-01 07:10:00',  'Late',    		'/path/to/checkin2.jpg'),
					(1, 'NV00000003', '2024-08-01 06:53:00',  'OnTime', 		'/path/to/checkin3.jpg'),
					(1, 'NV00000004', '2024-08-01 06:59:00',  'OnTime', 		'/path/to/checkin4.jpg'),
					(1, 'NV00000005', '2024-08-01 07:15:00',  'Late', 			'/path/to/checkin5.jpg'),
                    
					(2, 'NV00000001', '2024-08-15 06:10:00',  'OnTime', 		'/path/to/checkin1.jpg'),
					(2, 'NV00000002', '2024-08-15 06:05:00',  'OnTime',    		'/path/to/checkin2.jpg'),
					(2, 'NV00000003', '2024-08-15 06:53:00',  'OnTime', 		'/path/to/checkin3.jpg'),
					(2, 'NV00000004', '2024-08-15 06:59:00',  'OnTime', 		'/path/to/checkin4.jpg'),
					(2, 'NV00000005', '2024-08-15 06:15:00',  'OnTime', 		'/path/to/checkin5.jpg'),

					(3, 'NV00000001', '2024-09-01 06:10:00',  'OnTime', 		'/path/to/checkin1.jpg'),
					(3, 'NV00000002', '2024-09-01 06:05:00',  'OnTime',    		'/path/to/checkin2.jpg'),
					(3, 'NV00000003', '2024-09-01 06:53:00',  'OnTime', 		'/path/to/checkin3.jpg'),
					(3, 'NV00000004', '2024-09-01 07:00:00',  'Late', 			'/path/to/checkin4.jpg'),
					(3, 'NV00000005', '2024-09-01 06:15:00',  'OnTime', 		'/path/to/checkin5.jpg'),
                    
                    (4, 'NV00000001', '2024-09-10 06:10:00',  'OnTime', 		'/path/to/checkin1.jpg'),
					(4, 'NV00000002', '2024-09-10 07:05:00',  'Late',    		'/path/to/checkin2.jpg'),
					(4, 'NV00000003', '2024-09-10 06:53:00',  'OnTime', 		'/path/to/checkin3.jpg'),
					(4, 'NV00000004', '2024-09-10 06:59:00',  'OnTime', 		'/path/to/checkin4.jpg'),
					(4, 'NV00000005', '2024-09-10 06:15:00',  'OnTime', 		'/path/to/checkin5.jpg'),
                    
                    (5, 'NV00000001', '2024-10-05 06:10:00',  'OnTime', 		'/path/to/checkin1.jpg'),
					(5, 'NV00000002', '2024-10-05 06:05:00',  'OnTime',    		'/path/to/checkin2.jpg'),
					(5, 'NV00000003', '2024-10-05 06:53:00',  'OnTime', 		'/path/to/checkin3.jpg'),
					(5, 'NV00000004', '2024-10-05 06:59:00',  'OnTime', 		'/path/to/checkin4.jpg'),
					(5, 'NV00000005', '2024-10-05 06:15:00',  'OnTime', 		'/path/to/checkin5.jpg'),
                    
					-- (6, 'NV00000001', '2024-10-05 17:59:00',  'OnTime', 		'/path/to/checkin4.jpg'),
					(6, 'NV00000002', '2024-10-05 17:55:00',  'OnTime', 		'/path/to/checkin5.jpg');

						-- Insert sample data into the `CheckOut` table
INSERT INTO `CheckOut` (`shiftId`, `profileCode`, `checkOutTime`, `Status`, 		`image`) VALUES
						(1, 'NV00000001', '2024-08-01 17:31:00', 'OnTime', 			'/path/to/checkout1.jpg'),
						(1, 'NV00000002', '2024-08-01 17:35:00', 'OnTime', 			'/path/to/checkout2.jpg'),
						(1, 'NV00000003', '2024-08-01 17:12:00', 'LeavingEarly', 	'/path/to/checkout3.jpg'),
						(1, 'NV00000004', '2024-08-01 17:45:00', 'OnTime', 			'/path/to/checkout4.jpg'),
						(1, 'NV00000005', '2024-08-01 17:50:00', 'OnTime', 			'/path/to/checkout5.jpg'),
                        
						(2, 'NV00000001', '2024-08-15 17:31:00', 'OnTime', 			'/path/to/checkout1.jpg'),
						(2, 'NV00000002', '2024-08-15 17:35:00', 'OnTime', 			'/path/to/checkout2.jpg'),
						(2, 'NV00000003', '2024-08-15 17:45:00', 'OnTime', 			'/path/to/checkout3.jpg'),
						(2, 'NV00000004', '2024-08-15 17:45:00', 'OnTime', 			'/path/to/checkout4.jpg'),
						(2, 'NV00000005', '2024-08-15 17:50:00', 'OnTime', 			'/path/to/checkout5.jpg'),
                        
						(3, 'NV00000001', '2024-09-01 17:31:00', 'OnTime', 			'/path/to/checkout1.jpg'),
						(3, 'NV00000002', '2024-09-01 17:35:00', 'OnTime', 			'/path/to/checkout2.jpg'),
						(3, 'NV00000003', '2024-09-01 17:45:00', 'OnTime', 			'/path/to/checkout3.jpg'),
						(3, 'NV00000004', '2024-09-01 17:45:00', 'OnTime', 			'/path/to/checkout4.jpg'),
						(3, 'NV00000005', '2024-09-01 17:50:00', 'OnTime', 			'/path/to/checkout5.jpg'),
                        
						(4, 'NV00000001', '2024-09-10 17:31:00', 'OnTime', 			'/path/to/checkout1.jpg'),
						(4, 'NV00000002', '2024-09-10 17:35:00', 'OnTime', 			'/path/to/checkout2.jpg'),
						(4, 'NV00000003', '2024-09-10 17:45:00', 'OnTime', 			'/path/to/checkout3.jpg'),
						(4, 'NV00000004', '2024-09-10 17:45:00', 'OnTime', 			'/path/to/checkout4.jpg'),
						(4, 'NV00000005', '2024-09-10 17:50:00', 'OnTime', 			'/path/to/checkout5.jpg'),
                        
						(5, 'NV00000001', '2024-10-05 17:31:00', 'OnTime', 			'/path/to/checkout1.jpg'),
						(5, 'NV00000002', '2024-10-05 17:35:00', 'OnTime', 			'/path/to/checkout2.jpg'),
						(5, 'NV00000003', '2024-10-05 17:45:00', 'OnTime', 			'/path/to/checkout3.jpg'),
						(5, 'NV00000004', '2024-10-05 17:45:00', 'OnTime', 			'/path/to/checkout4.jpg'),
						(5, 'NV00000005', '2024-10-05 17:50:00', 'OnTime', 			'/path/to/checkout5.jpg'),
                        
						-- (6, 'NV00000001', '2024-10-05 21:40:00',  'OnTime', 		'/path/to/checkin4.jpg'),
						(6, 'NV00000002', '2024-10-05 21:42:00',  'OnTime', 		'/path/to/checkin5.jpg');


