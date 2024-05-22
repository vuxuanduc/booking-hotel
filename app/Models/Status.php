<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_status' ,
    ] ;
    
    // Kiểm tra xem có tồn tại bản ghi nào ở bảng reservations không để thực hiện chức năng xóa trạng thái ;
    public function reservations() {
        return $this->hasMany(Reservation::class) ;
    }
}
