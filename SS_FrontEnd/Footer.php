<footer id="footer" class="bg-white-800 py-10">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap justify-around">
            <!-- Contact Info -->
            <div class="w-full md:w-1/3 mb-4">
                <h5 class="text-gray text-lg font-semibold mb-4">Thông tin liên hệ</h5>
                <p class="text-gray">
                    <i class="fa-solid fa-location-dot mr-2"></i>
                    An Dương Vương, Phường 3, Quận 5
                </p>
                <p class="text-gray">
                    <i class="fa-solid fa-phone-volume mr-2"></i>
                    0776136425
                </p>
                <p class="text-gray">
                    <i class="fa-solid fa-envelope mr-2"></i>
                    hungnt.020404@gmail.com
                </p>
            </div>

            <!-- Follow Us -->
            <div class="w-full md:w-1/3 mb-4">
                <h5 class="text-gray text-lg font-semibold mb-4">FOLLOW US</h5>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/profile.php?id=100036421866670&locale=vi_VN" class="text-white">
                        <i id="fb" class="fa-brands fa-facebook text-2xl"></i>
                    </a>
                    <a href="https://www.instagram.com" class="text-white">
                        <i id="ig" class="fa-brands fa-instagram text-2xl"></i>
                    </a>
                    <a href="https://github.com/gnuh24" class="text-white">
                        <i id="git" class="fa-brands fa-github text-2xl"></i>
                    </a>
                    <a href="https://twitter.com/?lang=vi" class="text-blue-500 hover:text-blue-700">
                        <i id="tw" class="fa-brands fa-twitter text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="flex justify-center mt-8">
            <p class="text-gray text-center text-sm">Copyrights © 2024 by Thug24. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- CSS cho icon hover animation -->
<style>
    #fb,
    #tw,
    #git,
    #ig {
        font-size: 24px;
        background-color: #18191f;
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        animation: animate 3s linear infinite;
        text-shadow: 0 0 20px #0072ff, 0 0 50px #0072ff, 0 0 70px #0072ff, 0 0 100px #0072ff;
    }

    #tw {
        animation-delay: 0.7s;
    }

    #ig {
        animation-delay: 0.5s;
    }

    #git {
        animation-delay: 0.2s;
    }

    @keyframes animate {
        from {
            filter: hue-rotate(0deg);
        }
        to {
            filter: hue-rotate(360deg);
        }
    }
</style>
