<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<header id="mainHeader" class="flex items-center bg-white justify-between" style="height: 12vh; display: flex;">

    <div class="bg-white h-full w-auto" style="display: flex; align-items: center; justify-content: center; margin-left: 10%;">
        <img src="/SystemSecuritySGU/SS_FrontEnd/logo-removebg.png" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/HomePage.php';" alt="Logo" class="h-full w-auto" >
    </div>

    <div class="flex h-full">
        <div class="menu-item"  onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/HomePage.php';">Trang chủ</div>
        <div id="taikhoan"      onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/AdminUI/Account.php';"                style="display: none;" class="menu-item">Tài khoản</div>
        <div id="nhansu"        onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Profile/QLProfile.php';"    style="display: none;" class="menu-item">Nhân sự</div>
        <div id="calam"         onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Shift/QLShift.php';"        style="display: none;" class="menu-item">Ca làm</div>
        <div id="baocao"        onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/ManagerUI/Statistic/statistic.php';"  style="display: none;" class="menu-item">Báo cáo</div>
    </div>

    <!-- Thêm icon login và logout -->
    <div class="flex space-x-4" style="margin-right: 10%;">
        <!-- Kiểm tra xem người dùng đã login chưa để hiển thị icon logout hoặc login -->
        <i class="fas fa-user-circle text-2xl cursor-pointer" id="loginIcon" onclick="window.location.href='/SystemSecuritySGU/SS_FrontEnd/Login/login.php'" style="display: none;"></i>
        <i class="fas fa-sign-out-alt text-2xl cursor-pointer" id="logoutIcon" onclick="logout()"></i> <!-- Icon logout -->
    </div>    
</header>

<style>
    .menu-item {
        height: 100%;
        padding: 1.25rem; /* p-5 tương đương với padding 1.25rem */
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all 0.3s ease;
    }

    /* Khi ở trang chủ */
    .menu-item:hover {
        background: linear-gradient(135deg, #67a5e5, #9b59b6);
        color: white;
        cursor: pointer; /* Thay đổi con trỏ chuột khi hover */
    }

    /* Khi ở các trang khác (có class header-alt) */
    .header-alt .menu-item:hover {
        color: #8093d1;
        background: white;
        cursor: pointer; /* Thay đổi con trỏ chuột khi hover */
    }

    /* Đặt màu mặc định cho header khi không phải ở trang chủ */
    .header-alt {
        background: linear-gradient(135deg, #67a5e5, #9b59b6); /* Màu gradient */
        color: white;
    }

</style>

<script>
    // Hàm kiểm tra role từ localStorage và hiển thị các phần tử tương ứng
    window.onload = function() {
        const role = localStorage.getItem('role'); // Lấy role từ localStorage

        // Kiểm tra quyền và hiển thị các phần tử
        if (role) {
            // Nếu người dùng đã login (role tồn tại trong localStorage)
            document.getElementById('logoutIcon').style.display = 'flex'; // Hiển thị logout icon
            document.getElementById('loginIcon').style.display = 'none'; // Ẩn login icon

            if (role === 'Admin') {
                document.getElementById('taikhoan').style.display = 'flex'; // Hiển thị "Tài khoản"
            }
            if (role === 'Manager') {
                document.getElementById('nhansu').style.display = 'flex'; // Hiển thị "Nhân sự"
                document.getElementById('calam').style.display = 'flex'; // Hiển thị "Ca làm"
                document.getElementById('baocao').style.display = 'flex'; // Hiển thị "Báo cáo"
            }
        } else {
            // Nếu người dùng chưa login (role không tồn tại trong localStorage)
            document.getElementById('logoutIcon').style.display = 'none'; // Ẩn logout icon
            document.getElementById('loginIcon').style.display = 'flex'; // Hiển thị login icon
        }

        // Kiểm tra xem URL hiện tại có phải là trang chủ không
        const currentPage = window.location.pathname;

        if (currentPage !== '/SystemSecuritySGU/SS_FrontEnd/HomePage.php') {
            // Nếu không phải trang chủ, thay đổi màu header
            document.getElementById('mainHeader').classList.add('header-alt');
        }
    };

    // Hàm xử lý đăng xuất
    function logout() {
        localStorage.clear();
        window.location.href='/SystemSecuritySGU/SS_FrontEnd/HomePage.php'
    }
</script>
