<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div> <a href="{{ route('/') }}" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span
                    class="nav_logo-name">BookingHotel</span> </a>
            <div class="nav_list">
                <a href="{{ route('dashboard') }}" class="nav_link active"> <i class='bx bx-home-alt nav_icon'></i>
                    <span class="nav_name">Trang chủ</span> </a>
                <a href="{{ route('hotels.index') }}" class="nav_link"> <i class="fa-solid fa-hotel"></i> <span
                        class="nav_name">Khách sạn</span> </a>
                <a href="{{ route('room-types.index') }}" class="nav_link"> <i class='bx bx-category-alt nav_icon'></i> <span
                        class="nav_name">Loại phòng</span> </a>
                <a href="{{ route('rooms.index') }}" class="nav_link"> <i class='bx bx-hotel nav_icon'></i> <span
                        class="nav_name">Phòng</span> </a>
                <a data-bs-toggle="collapse" style="cursor: pointer;" data-bs-target="#collapse" class="nav_link"> <i class='bx bx-image-alt nav_icon'></i> <span
                        class="nav_name">Ảnh</span> </a>
                        <ul id="collapse" class="collapse">
                             <a href="{{ route('manager-images-all-hotel') }}" class="nav_link"> <i class='bx bx-image-alt nav_icon'></i> <span
                                class="nav_name">Ảnh khách sạn</span> </a>
                             <a href="{{ route('manager-images-all-room') }}" class="nav_link"> <i class='bx bx-image-alt nav_icon'></i> <span
                                class="nav_name">Ảnh phòng</span> </a>
                        </ul>
                <a href="{{ route('users.index') }}" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span
                        class="nav_name">Người dùng</span> </a>
                <a href="{{ route('manager-ratings-all-hotel') }}" class="nav_link"> <i class="fa-regular fa-star"></i> <span
                        class="nav_name">Đánh giá</span> </a>
                <a href="{{ route('manager-comments-all-hotel') }}" class="nav_link"> <i class='bx bx-comment nav_icon'></i> <span
                        class="nav_name">Bình luận</span> </a>
                <a href="{{ route('manager-reservations') }}" class="nav_link"> <i class="fa-brands fa-buy-n-large"></i> <span
                        class="nav_name">Đặt phòng</span> </a>
                <a href="{{ route('statuses.index') }}" class="nav_link"> <i class="fa-solid fa-face-smile"></i> <span
                        class="nav_name">Trạng thái</span> </a>
                <a href="{{ route('manager-pays') }}" class="nav_link"> <i class='bx bx-credit-card nav_icon'></i> <span
                        class="nav_name">Thanh toán</span> </a>
                <a href="{{ route('chart-revenue') }}" class="nav_link"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span
                        class="nav_name">Thống kê</span> </a>
            </div>
        </div> <a href="#" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span
                class="nav_name">SignOut</span> </a>
    </nav>
</div>