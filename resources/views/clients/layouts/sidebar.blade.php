<div>
    <div style="border:1px dotted gray;margin-top:5px;">
        <div style="width:100%;background-color:#86B817;">
            <h6 class="text-center py-2 text-white title-h6">TÌM KHÁCH SẠN</h6>
        </div>
        <div class="px-2">
            <form action="{{ route('search-hotel') }}" method="get" onsubmit="return validateSearch();">
                @csrf
                <div class="form-group">
                    <label for="">KHÁCH SẠN</label>
                    <input style="height:30px;" type="text" name="name_hotel" id="nameHotelSearch" placeholder="Tên khách sạn..." class="form-control my-2">
                </div>
                <div class="form-group">
                    <label for="">NGÀY NHẬN PHÒNG</label>
                    <input style="height:30px;" name="check_in_date" id="myID" placeholder="Ngày đến..." class="form-control my-2 checkInSearch">
                </div>
                <div class="form-group">
                    <label for="">NGÀY TRẢ PHÒNG</label>
                    <input style="height:30px;" name="check_out_date" placeholder="Ngày đi..." id="myID" class="form-control my-2 checkOutSearch">
                </div>
                <div class="form-group">
                    <label for="">SỐ NGƯỜI</label>
                    <input style="height:30px;" name="number_people" placeholder="Số người" id="quantitySearch" type="number" min="0" step="1" class="form-control my-2">
                </div>
                <div class="form-group">
                    <input type="submit" value="TÌM PHÒNG" class="form-control my-3" style="background-color:#86B817;color:white;">
                </div>
            </form>
        </div>
    </div>
    <div style="border:1px dotted gray; margin-top:30px;">
        <div style="width:100%;background-color:#86B817;">
            <h6 class="text-center py-2 text-white">LỰA CHỌN PHỔ BIẾN</h6>
        </div>
        <div class="px-2">
            <ul class="top-views top-reservation">
                @foreach ($topBookings as $keyBooking => $valueBooking)
                    <li class="d-flex">
                        <img src="{{ asset($valueBooking->image_hotel) }}" width="70px" height="auto" alt="">
                        <a href="{{ route('hotel-detail' , ['id' => $valueBooking->id]) }}"><h6>{{ $valueBooking->name_hotel }}</h6></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div style="border:1px dotted gray; margin-top:30px;">
        <div style="width:100%;background-color:#86B817;">
            <h6 class="text-center py-2 text-white">TOP LƯỢT XEM</h6>
        </div>
        <div class="px-2">
            <ul class="top-views">
                @foreach ($topViewHotel as $keyViewHotel => $valueViewHotel)
                    <li class="d-flex">
                        <img src="{{ asset($valueViewHotel->image_hotel) }}" width="70px" height="auto" alt="">
                        <a href="{{ route('hotel-detail' , ['id' => $valueViewHotel->id]) }}"><h6>{{ $valueViewHotel->name_hotel }}</h6></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

