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
        <form action="{{ route('hotels.update' , $hotelId->id) }}" method="post" onsubmit="return validateFormUpdateHotel();">
            @csrf
            @method("PUT")
            <div class="row mb-4">
                <div class="col-6">
                    <div class="form-group mt-3">
                        <label for="">Chọn Tỉnh/Thành phố</label> <span id="province_err"></span>
                        <select id="provinceSelect" class="form-select mt-2" id="province">
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
                    <div class="form-group mt-3">
                        <label for="">Trạng thái</label>
                        <select name="status" class="form-select mt-2">
                            <option {{ $hotelId->status == 1 ? "selected" : "" }} value="1">Hoạt động</option>
                            <option {{ $hotelId->status == 2 ? "selected" : "" }} value="2">Tạm ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mt-3">
                        <label for="">Tên khách sạn</label> <span id="name_hotel_err"></span>
                        <input type="text" value="{{ $hotelId->name_hotel }}" placeholder="Tên khách sạn..." name="name_hotel" id="name_hotel" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Email</label> <span id="email_err"></span>
                        <input type="text" value="{{ $hotelId->email }}" placeholder="Email..." name="email" id="email" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Số điện thoại</label> <span id="phone_err"></span>
                        <input type="text" value="{{ $hotelId->phone }}" placeholder="Số điện thoại..." name="phone" id="phone" class="form-control mt-2">
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Địa điểm hiện tại</label>
                        <input type="text" value="{{ $hotelId->address }}" id="hidden_address" readonly name="address" class="form-control mt-2">
                    </div>
                    
                </div>
            </div>
            <div>
                <label for="" class="my-2">Mô tả khách sạn</label> <span id="description_err"></span>
                <textarea class="tinymce" name="description" id="description" cols="30" rows="20">
                    {{ $hotelId->description }}
                </textarea>
            </div>
            <button id="btn-update-hotel" type="submit" class="btn text-white fw-bold mt-3" style="background-color: #86B817;">Cập nhật khách sạn</button>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/address.js') }}"></script>
    <script>
        function validateFormUpdateHotel() {
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

            let check = true ;

            if(province.value.trim() != "") {
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

        document.getElementById('btn-update-hotel').addEventListener('click' , () => {
            const province = provinceSelect.options[provinceSelect.selectedIndex].text;
            const district = districtSelect.options[districtSelect.selectedIndex].text;
            const ward = wardSelect.options[wardSelect.selectedIndex].text;
            const address = document.getElementById('address').value ;
            const hidden_address = document.getElementById('hidden_address') ;
            if(document.getElementById('provinceSelect').value != "") {
                hidden_address.value = address + ', ' + ward + ', ' + district + ', ' + province ;
            }
        })
    </script>
@endsection