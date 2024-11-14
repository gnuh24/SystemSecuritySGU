<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<header id="mainHeader" class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-900 to-blue-900 shadow-lg relative overflow-hidden" style="height: 12vh;">
    <div class="absolute inset-0 bg-[url('/path/to/your/circuit-pattern.png')] opacity-10"></div> <!-- Thay đổi đường dẫn đến hình nền mạch điện -->
    
    <div class="flex items-center z-10">
        <img src="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/HomePage.php';" alt="Logo" class="h-16 w-auto transform transition-transform duration-300 hover:scale-110" style="filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5));">
    </div>

    <nav class="flex space-x-6 z-10">
        <div class="menu-item" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/HomePage.php';">Trang chủ</div>
        <div id="taikhoan" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/AdminUI/Account.php';" style="display: none;" class="menu-item">Tài khoản</div>
        <div id="nhansu" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/QLProfile.php';" style="display: none;" class="menu-item">Nhân sự</div>
        <div id="calam" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Shift/QLShift.php';" style="display: none;" class="menu-item">Ca làm</div>
        <div id="baocao" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Statistic/statistic.php';" style="display: none;" class="menu-item">Báo cáo</div>
    </nav>

    <div class="flex items-center space-x-4 z-10">
        <i class="fas fa-user-circle text-2xl cursor-pointer text-white transition-transform duration-300 hover:scale-110" id="loginIcon" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/Login/login.php'" style="display: none;"></i>
        <i class="fas fa-sign-out-alt text-2xl cursor-pointer text-white transition-transform duration-300 hover:scale-110" id="logoutIcon" onclick="logout()"></i>
    </div>    
</header>

<style>
    body {
       
        font-family: 'Roboto', sans-serif; /* Phông chữ hiện đại */
    }

    .menu-item {
        height: 100%;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        text-transform: uppercase; /* Chữ in hoa */
        letter-spacing: 0.1em; /* Khoảng cách giữa các chữ */
        transition: background 0.3s ease, color 0.3s ease, transform 0.3s ease;
        border-radius: 0.5rem; /* Bo tròn góc */
        position: relative; /* Để tạo hiệu ứng sau */
        overflow: hidden; /* Ẩn phần thừa ra */
        backdrop-filter: blur(5px); /* Làm mờ nền */
    }

    /* Hiệu ứng hover cho menu-item */
    .menu-item:hover {
        background: rgba(255, 255, 255, 0.1); /* Nền trong suốt khi hover */
        color: #ffcc00; /* Đổi màu chữ khi hover */
        cursor: pointer;
    }

    /* Hiệu ứng gạch ngang khi hover */
    .menu-item::before {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 100%;
        height: 2px;
        background: #ffcc00; /* Màu vàng cho đường gạch */
        transform: translateX(-50%) scaleX(0);
        transition: transform 0.3s ease;
    }

    .menu-item:hover::before {
        transform: translateX(-50%) scaleX(1); /* Hiện đường gạch khi hover */
    }

    /* Đặt màu mặc định cho header khi không phải ở trang chủ */
    .header-alt {
        background: linear-gradient(135deg, #67a5e5, #9b59b6);
        color: white;
    }

    i {
        transition: color 0.3s ease;
    }

    /* Hiệu ứng hover cho các icon */
    i:hover {
        color: #ffcc00; /* Màu vàng khi hover */
    }
</style>

<script>
    // Hàm kiểm tra role từ localStorage và hiển thị các phần tử tương ứng
    window.onload = function() {
        const role = localStorage.getItem('role');

        if (role) {
            document.getElementById('logoutIcon').style.display = 'flex';
            document.getElementById('loginIcon').style.display = 'none';

            if (role === 'Admin') {
                document.getElementById('taikhoan').style.display = 'flex';
            }
            if (role === 'Manager') {
                document.getElementById('nhansu').style.display = 'flex';
                document.getElementById('calam').style.display = 'flex';
                document.getElementById('baocao').style.display = 'flex';
            }
        } else {
            document.getElementById('logoutIcon').style.display = 'none';
            document.getElementById('loginIcon').style.display = 'flex';
        }

        const currentPage = window.location.pathname;

        if (currentPage !== '/SystemSecuritySGU/SS_FrontEnd/HomePage.php') {
            document.getElementById('mainHeader').classList.add('header-alt');
        }
    };

    // Hàm xử lý đăng xuất
    function logout() {
        localStorage.clear();
        window.location.href='/SystemSecuritySGU/SS_FrontEnd/HomePage.php';
    }
</script>