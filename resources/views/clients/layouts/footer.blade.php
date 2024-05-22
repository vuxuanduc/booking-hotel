</div>
<div class="container">
<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/11.jpg') }}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/22.jpg') }}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/33.jpg') }}" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/44.jpg') }}" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
        <hr style="border: 2px solid #86B817;">
        <footer>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2">
                    <img class="logo-footer" src="{{ asset('images/1-removebg-preview.png') }}" alt="">

                    <h6 class="my-2">ĐỪNG BỎ LỠ CƠ HỘI GIÁ TỐT</h6>
                    <p class="text-description">Du lịch sẽ cập nhật thường xuyên về những ưu đãi, khuyến mãi mới và hot trong tháng đến quý khách.</p>
                    <img width="150px" height="auto" src="{{ asset('images/logoBCT.png') }}" alt="">
                </div>
                <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2">
                    <h6>DU LỊCH 24</h6>
                    <ul class="nav-footer">
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Cơ hội nghề nghiệp</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Cẩm nang Du Lịch</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Câu Hỏi Thường Gặp</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Chính Sách Quyền Riêng Tư</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Tích lũy điểm thưởng</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Khách hàng thân thiết</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2">
                    <h6>LIÊN KẾT NHANH</h6>
                    <ul class="nav-footer">
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Đánh giá khách sạn</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Địa điểm</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Khu vực</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Resort</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Villa</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Thông tin về tiêu chuẩn khách sạn</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-md-4 col-sm-6 col-12 my-2">
                    <h6>LIÊN HỆ</h6>
                    <ul class="nav-footer">
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Tầng 10, số 60 Nguyễn Đình Chiểu, Phường Đa Kao, Quận 1, Tp Hồ Chí Minh.</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>1900 54 54 40 (1000đ/phút)</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>vuxuanduc33@gmail.com</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>2008 Công Ty Cổ Phần Dịch Vụ Du Lịch Hai Bốn.</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>ĐT: 028 73030 588 - 028 3925 1055</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger
    intent="WELCOME"
    chat-title="BookingRoom"
    agent-id="29a60061-2c22-4925-b8e8-44f01874df15"
    language-code="vi"
    ></df-messenger>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#myID", {});
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script> --}}
    {{-- <script>
        document.addEventListener('keydown' , (event) => {
            if(event.keyCode == 123) {
                event.preventDefault() ;
            }

            if(event.ctrlKey && event.shiftKey && (event.keyCode == 73 || event.keyCode == 74)) {
                event.preventDefault() ;
            }

            if(event.ctrlKey && event.keyCode == 85) {
                event.preventDefault() ;
            }
        }) ;

        document.addEventListener('contextmenu' , (event) => {
            event.preventDefault() ;
        })
    </script> --}}
</body>

</html>