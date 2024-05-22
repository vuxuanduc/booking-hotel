<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id' ,
        'pay_info' ,
    ] ;

    public function listPays() {
        return $this->select('pays.id' , 'pays.reservation_id' , 'pays.pay_info' , 'reservations.total_amount' , 'users.email')
                    ->join('reservations' , 'reservations.id' , '=' , 'pays.reservation_id')
                    ->join('users' , 'users.id' , '=' , 'reservations.user_id')
                    ->orderByDesc('pays.id')
                    ->paginate(10) ;
    }
}
