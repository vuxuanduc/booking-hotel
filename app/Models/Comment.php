<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id' ,
        'hotel_id' ,
        'content_comment' ,
        'date_comment' ,
    ] ;

    protected $table = 'comments' ;
    // Lấy  danh sách comment của mỗi khách sạn đổ ra trang chi tiết khách sạn ;
    public function listComments($id) {
        return $this->select('comments.id' , 'comments.content_comment' , 'comments.date_comment' , 'users.email')
                    ->join('users' , 'comments.user_id' , '=' , 'users.id')
                    ->where('comments.hotel_id' , $id)
                    ->where('comments.status' , 1)
                    ->groupBy('comments.id' , 'comments.content_comment' , 'comments.date_comment' , 'users.email')
                    ->orderByDesc('comments.id')
                    ->get() ;
    }

    // Số lượt bình luận trên mỗi khách sạn đổ ra trang quản lí comment  tất cả các khách sạn ;
    public function listCommentAdminAllHotel() {
        return $this->select('hotels.id' , 'hotels.name_hotel' , DB::raw('count(*) as total_comments'))
                    ->join('hotels' , 'comments.hotel_id' , '=' , 'hotels.id')
                    ->groupBy('hotels.id' , 'hotels.name_hotel')
                    ->orderByDesc('total_comments')
                    ->paginate(10) ;
    }
    // Danh sách bình luận cuả mỗi khách sạn đổ ra trang admin ;
    public function listCommentsAdmin($hotelId) {
        return $this->select('comments.id' , 'comments.content_comment' , 'comments.date_comment' , 'comments.status' , 'users.email')
                    ->join('users' , 'users.id' , '=' , 'comments.user_id')
                    ->where('comments.hotel_id' , $hotelId)
                    ->orderByDesc('comments.date_comment')
                    ->paginate(10) ;
    }
    // Ẩn bình luận ;
    public function hiddenComment($comment_id) {
        return Comment::where('id' , $comment_id)->update(['status' => 2]) ;
    }
    // Hiển thị bình luận bị ẩn ;
    public function showComment($comment_id) {
        return Comment::where('id' , $comment_id)->update(['status' => 1]) ;
    }


}
