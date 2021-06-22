@extends('home')
@section('title', 'Chỉnh sửa khách hàng')

@section('content')
    <div class="col-12 col-md-12">
        <div class="row">
            <div class="col-12">
                <h1>Chỉnh sửa khách hàng</h1>
            </div>
            <a class="btn btn-outline-primary" href="" data-toggle="modal" data-target="#cityModal">Lọc</a>
            <div class="col-12">
                <form method="post" action="{{ route('customers.update',$customer->id) }}">
                    @csrf
                    <div class="form-group">
                        <label>Tên khách hàng</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name" value="{{$customer->name}}">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Enter email" value="{{$customer->email}}">
                        @error('email')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ngày sinh</label>
                        <input type="date" class="form-control" name="dob" value="{{$customer->dob}}">
                        @error('dob')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tỉnh thành</label>
                        <select class="form-control" name="city_id">
                            @foreach($cities as $city)
                                @if($city->id ==$customer->city_id)
                                    <option value="{{$city->id}}" selected>{{$city->name}}</option>
                                @endif
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
