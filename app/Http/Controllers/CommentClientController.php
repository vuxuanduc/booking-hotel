<?php

namespace App\Http\Controllers;

use App\Http\Requests\clients\CommentRequest;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CommentClientController extends Controller
{
    public function postComment(CommentRequest $request) {

        // Xử lí form request ở CommentRequest sau đó chuyển dữ liệu về phương thức này ;

        $user = User::where('email' , $request->email)->first() ;

        $data = $request->except('email') ;

        $data['user_id'] = $user->id ;

        $data['date_comment'] = date('Y-m-d') ;

        Comment::query()->create($data) ;

        $data['email'] = Session::get('email') ;
        
        return response()->json(['status' => 'success' , 'data' => $data]) ;
    }
}
