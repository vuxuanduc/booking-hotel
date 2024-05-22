<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $comments ;

    public function __construct() {
        $this->comments = new Comment() ;
    }

    public function managerCommentAllHotelController() {

        $title = "Quản lí bình luận" ;

        $listCommentsAllHotel = $this->comments->listCommentAdminAllHotel() ;

        return view('admins.comments.manager_comment_all_hotel' , compact('title' , 'listCommentsAllHotel')) ;
    }

    public function managerCommentHotelController(Request $request) {

        $hotelId = $request->hotel_id ;

        $title = "Danh sách bình luận theo khách sạn" ;

        $listComments = $this->comments->listCommentsAdmin($hotelId) ;

        return view('admins.comments.manager_comment_hotel' , compact('title' , 'listComments')) ;
    }

    public function hiddenComment(Request $request) {

        $commentId = $request->comment_id;
        
        $this->comments->hiddenComment($commentId) ;
    
        return back();
    }

    public function showComment(Request $request) {

        $commentId = $request->comment_id;
        
        $this->comments->showComment($commentId) ;
    
        return back();
    }
}
