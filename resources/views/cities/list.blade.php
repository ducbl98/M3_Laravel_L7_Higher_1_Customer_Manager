@extends('home')
@section('title','Danh sách tỉnh thành')
@section('content')
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <h1>Danh sách tỉnh thành</h1>
            </div>
            <div class="col-12">
                @if (Session::has('success'))
                    <p class="text-success">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        {{ Session::get('success') }}
                    </p>
                @endif
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên tỉnh thành</th>
                    <th scope="col">Số khách hàng</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($cities as $key =>$city)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$city->name}}</td>
                        <td>{{count($city->customers)}}</td>
                        <td><a href="{{route('cities.edit',$city->id)}}">Sửa</a></td>
                        <td><a href="{{route('cities.destroy',$city->id)}}">Xóa</a></td>
                    </tr>
                @empty
                <tr>
                    <td colspan="4">Không có dữ liệu</td>
                </tr>
                @endforelse
                </tbody>
            </table>
            <a class="btn btn-primary" href="{{route('cities.create')}}">Thêm mới</a>
        </div>
    </div>
@endsection
