<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\admins\StatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $title = "Quản lí trạng thái" ;

        $listStatus = Status::query()->first('id')->paginate(10) ;

        return view('admins.status.manager_status' , compact('title' , 'listStatus')) ;
    }

    public function create()
    {
        $title = "Thêm mới trạng thái" ;

        return view('admins.status.create_status' , compact('title')) ;
    }

    public function store(StatusRequest $request)
    {
        $data = $request->all() ;

        Status::query()->create($data) ;

        return response()->json(['status' => 'success']) ;
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $title = "Cập nhật trạng thái" ;

        $status = Status::find($id) ;

        return view('admins.status.update_status' , compact('title' , 'status')) ;
    }

    public function update(StatusRequest $request, string $id)
    {
        $status = Status::find($id) ;

        $data['name_status'] = $request->name_status ;

        $status->update($data) ;

        return response()->json(['status' => 'success']) ;
    }

    public function destroy(string $id)
    {
        $status = Status::find($id) ;

        $status->delete() ;

        return back() ;
    }
}
