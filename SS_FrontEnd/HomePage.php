<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <title>Time Attendance</title>
    <link rel="icon" type="image/png" href="./logo-removebg.png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .fade-in {
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeIn 1s ease-in-out forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* Style for button animations */
        .animated-button {
            position: relative;
            overflow: hidden;
            padding: 1rem 2rem;
            font-size: 1.25rem;
            font-weight: bold;
            color: #fff;
            background-color: #6b46c1;
            border-radius: 9999px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            transition: transform 0.3s;
        }
        .animated-button::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.6), transparent);
            opacity: 0;
            transition: opacity 0.3s, transform 0.5s;
            transform: scale(0);
            border-radius: 50%;
        }
        .animated-button:hover {
            transform: scale(1.05);
        }
        .animated-button:hover::before {
            opacity: 0.5;
            transform: scale(1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-800 via-blue-800 to-purple-900 text-white font-sans h-screen">

    <?php include_once './header.php'; ?>

    <div class="flex flex-col items-center justify-center h-full px-4">
        <div class="text-center fade-in">
            <h1 class="text-5xl font-extrabold mb-6 animate-pulse">Chào mừng bạn đến với Hệ thống chấm công!</h1>
            <p class="text-lg mb-10">Sử dụng chức năng check-in và check-out để ghi nhận thời gian làm việc của bạn.</p>
            <button id="animatedButton" class="animated-button">
                <i class="fas fa-fingerprint mr-2"></i> Check In Ngay
            </button>
        </div>
    </div>

    <?php include_once './footer.php'; ?>

    <script>
        const button = document.getElementById('animatedButton');
        // Button ripple effect on click
        button.addEventListener('click', function (e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            ripple.style.left = `${e.clientX - button.offsetLeft}px`;
            ripple.style.top = `${e.clientY - button.offsetTop}px`;
            button.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    </script>
</body>
</html>