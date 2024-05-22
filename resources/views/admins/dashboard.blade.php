@extends('admins.master_layout_admin')

@section('pageTitle')
    {{ $title }}
@endsection

@section('css')
    
@section('content')
    @include('admins.layouts.admin_sidebar')
    <div class="height-100">
        <h1>Quản lí trang web</h1>
    </div>
@endsection

@section('script')
    
@endsection

