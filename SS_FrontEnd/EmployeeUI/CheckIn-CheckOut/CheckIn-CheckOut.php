<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Check-In/Check-Out</title>
    <style>
        /* Global styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #4c8bf5, #9b4dff);
            font-family: Arial, sans-serif;
            color: #3a2ecc;
        }

        /* Container styling */
        .container {
            height: 370px;
            background-color: #edf3ff;
            padding: 30px;
            border-radius: 20px;
            width: 500px;
            text-align: center;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Title */
        h2 {
            position: absolute;
            top: 136px;
            color: #3a2ecc;
            font-size: 32px;
            margin-bottom: 20px;
        }

        /* Input group styling */
        .input-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }

        .input-box {
            background-color: #dcd8f0;
            border-radius: 12px;
            width: 45%;
            color: #6d5a8d;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
        }

        /* Styling for file input */
        .file-input {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            background-color: #6d47cc;
            color: #6d5a8d;
            text-align: center;
            cursor: pointer;
            outline: none;
            box-sizing: border-box;
        }

        .choose-img {
            position: relative;
            top: 40px;
        }

        .file-input::before {
            content: 'Select Fingerprint Image';
            display: inline-block;
            width: 100%;
            height: 100%;
            padding: 10px 0;
            color: #6d5a8d;
            background-color: #e1b0ff;
            border-radius: 12px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
        }

        /* Hover effect for Select Fingerprint Image button */
        .file-input:hover::before {
            background-color: #b58ce6;
            /* Màu nền khi hover */
            color: #fff;
            /* Màu chữ khi hover */
        }

        /* Hide default file input appearance */
        .file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        /* Styling for dropdown */
        .dropdown {
            position: absolute;
            top: 100px;
            width: 44%;
            height: 28%;
            padding: 10px;
            font-size: 14px;
            color: #6d5a8d;
            background-color: #e1b0ff;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            outline: none;
            box-sizing: border-box;
            margin-top: 10px;
        }

        /* Button styling */
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            height: 60px;
        }

        .btn {
            padding: 10px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s;
            width: 45%;
        }

        .btn-checkin {
            background-color: #4c3ff5;
        }

        .btn-checkin:hover {
            background-color: #3a2ecc;
        }

        .btn-checkout {
            background-color: #8b5aff;
        }

        .btn-checkout:hover {
            background-color: #6d47cc;
        }

        .image {
            height: 200px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Employee</h2>
        <div class="input-group">
            <div class="input-box ID">Employee's code</div>
            <div class="input-box name">Employee's name</div>
        </div>
        <div class="input-group">
            <label class="input-box choose-img">
                <input type="file" class="file-input" accept="image/*" onchange="displayImage(event)">
            </label>
            <!-- Dropdown menu for shift selection -->
            <select class="dropdown">
                <option value="">Select shift</option>
                <!-- load các ca là của nhân viên x -->
            </select>
            <div class="input-box image">
                <img id="selectedImage" alt="Selected Image" src="" style="display: none; max-width: 100%; max-height: 100px;">
            </div>
        </div>
        <div class="buttons">
            <button class="btn btn-checkin">Check in</button>
            <button class="btn btn-checkout">Check out</button>
        </div>
    </div>
    <script>
        function displayImage(event) {
            const image = document.getElementById('selectedImage');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block'; // Show the image
        }
    </script>
</body>

</html>