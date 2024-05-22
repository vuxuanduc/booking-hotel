@extends('admins.master_layout_admin')

@section('pageTitle')
    {{ $title }}
@endsection

@section('TinyMCE')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.0.0/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '.tinymce' ,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
        });
    </script>
@endsection

@section('css')
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        label {
            font-weight: 600 ;
        }

        .form-group span {
            color : red ;
            margin-left: 10px ;
        }
    </style>
@endsection

@section('content')
    @include('admins.layouts.admin_sidebar')

    <div class="height-100">
        <h2 class="mt-3">{{ $title }}</h2>
        <form action="{{ route('hotels.store') }}" method="post" onsubmit="return validateFormAddHotel();">
            @csrf
            <div class="row mb-4">
                <div class="col-6">
                    <div class="form-group mt-3">
                        <label for="">Chọn Tỉnh/Thành phố</label> <span id="province_err"></span>
                        <select id="provinceSelect" class="form-select mt-2">
                            <option value="">Chọn tỉnh/thành phố</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Chọn Quận/Huyện</label> <span id="district_err"></span>
                        <select id="districtSelect" class="form-select mt-2">
                            <option value="">Chọn quận/huyện</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Chọn Phường/Xã</label> <span id="ward_err"></span>
                        <select id="wardSelect" class="form-select mt-2">
                            <option value="">Chọn phường/xã</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Nhập địa điểm</label> <span id="address_err"></span>
                        <input type="text" placeholder="Địa chỉ..." id="address" class="form-control mt-2">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mt-3">
                        <label for="">Tên khách sạn</label> <span id="name_hotel_err"></span>
                        <input type="text" placeholder="Tên khách sạn..." name="name_hotel" id="name_hotel" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Email</label> <span id="email_err"></span>
                        <input type="text" placeholder="Email..." name="email" id="email" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Số điện thoại</label> <span id="phone_err"></span>
                        <input type="text" placeholder="Số điện thoại..." name="phone" id="phone" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <input type="hidden" id="hidden_address" name="address" placeholder="Địa chỉ..." class="form-control mt-2">
                    </div>
                </div>
            </div>
            <div>
                <label for="" class="my-2">Mô tả khách sạn</label> <span id="description_err"></span>
                <textarea class="tinymce" name="description" id="description" cols="30" rows="20">
                
                </textarea>
            </div>
            <button id="btn-add-hotel" type="submit" class="btn text-white fw-bold mt-3" style="background-color: #86B817;">Thêm khách sạn</button>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/address.js') }}"></script>
    <script>
        function validateFormAddHotel() {
            const province = document.getElementById('provinceSelect') ;
            const province_err = document.getElementById('province_err') ;
            const district = document.getElementById('districtSelect') ;
            const district_err = document.getElementById('district_err') ;
            const ward = document.getElementById('wardSelect') ;
            const ward_err = document.getElementById('ward_err') ;
            const address = document.getElementById('address') ;
            const address_err = document.getElementById('address_err') ;
            const name_hotel = document.getElementById('name_hotel') ;
            const name_hotel_err = document.getElementById('name_hotel_err') ;
            const email = document.getElementById('email') ;
            const email_err = document.getElementById('email_err') ;
            const phone = document.getElementById('phone') ;
            const phone_err = document.getElementById('phone_err') ;
            const description = document.getElementById('description') ;
            const description_err = document.getElementById('description_err') ;

            let check = true ;

            if(province.value.trim() == "") {
                province_err.textContent = "Vui lòng chọn tỉnh/thành phố" ;
                check = false ;
            }else {
                province_err.textContent = "" ;
            }

            if(district.value.trim() == "") {
                district_err.textContent = "Vui lòng chọn quận/huyện" ;
                check = false ;
            }else {
                district_err.textContent = "" ;
            }

            if(ward.value.trim() == "") {
                ward_err.textContent = "Vui lòng chọn phường/xã" ;
                check = false ;
            }else {
                ward_err.textContent = "" ;
            }

            if (address.value.trim() === "") {
                address_err.textContent = "Vui lòng nhập địa chỉ";
                check = false;
            } else if (address.value.trim().length < 6) {
                address_err.textContent = "Địa chỉ phải chứa ít nhất 6 kí tự";
                check = false;
            } else {
                address_err.textContent = "";
            }

            if (name_hotel.value.trim() === "") {
                name_hotel_err.textContent = "Vui lòng nhập tên khách sạn";
                check = false;
            } else if (name_hotel.value.trim().length < 6) {
                name_hotel_err.textContent = "Tên khách sạn phải chứa ít nhất 6 kí tự";
                check = false;
            } else {
                name_hotel_err.textContent = "";
            }

            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === "") {
                email_err.textContent = "Vui lòng nhập email";
                check = false;
            } else if (!emailRegex.test(email.value.trim())) {
                email_err.textContent = "Email không hợp lệ";
                check = false;
            } else {
                email_err.textContent = "";
            }

            let phoneRegex = /^0\d{9,10}$/;
            if (phone.value.trim() === "") {
                phone_err.textContent = "Vui lòng nhập số điện thoại";
                check = false;
            } else if (!phoneRegex.test(phone.value.trim())) {
                phone_err.textContent = "Số điện thoại không hợp lệ";
                check = false;
            } else {
                phone_err.textContent = "";
            }

            return check ;
        }

        document.getElementById('btn-add-hotel').addEventListener('click' , () => {
            const province = provinceSelect.options[provinceSelect.selectedIndex].text;
            const district = districtSelect.options[districtSelect.selectedIndex].text;
            const ward = wardSelect.options[wardSelect.selectedIndex].text;
            const address = document.getElementById('address').value ;
            const hidden_address = document.getElementById('hidden_address') ;
            hidden_address.value = address + ', ' + ward + ', ' + district + ', ' + province ;
        })
    </script>
@endsection