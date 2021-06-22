@extends('home')
@section('title', 'Danh sách khách hàng')
@section('content')
    <div class="col-12">
        <div class="row">
            <div class="col-12"><h1>Danh Sách Khách Hàng</h1></div>
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-outline-primary" href="" data-toggle="modal" data-target="#cityModal">
                            Lọc
                        </a>
                    </div>
                    <div class="col-6">
                        <form class="navbar-form navbar-left" action="{{route('customers.search')}}">
                            @csrf
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Search" name="keyword">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                @if (Session::has('success'))
                    <p class="text-success">
                        <i class="fa fa-check" aria-hidden="true"></i>{{ Session::get('success') }}
                    </p>
                @endif
            </div>
            @if(isset($totalCustomerFilter))
                <span class="text-muted">
                    {{'Tìm thấy' . ' ' . $totalCustomerFilter . ' '. 'khách hàng:'}}
                </span>
            @endif

            @if(isset($cityFilter))
                <div class="pl-5">
                   <span class="text-muted"><i class="fa fa-check" aria-hidden="true"></i>
                       {{ 'Thuộc tỉnh' . ' ' . $cityFilter->name }}</span>
                </div>
            @endif
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên khách hàng</th>
                    <th scope="col">Ngày Sinh</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tỉnh</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($customers as $key=>$customer)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$customer->name}}</td>
                        <td>{{$customer->dob}}</td>
                        <td>{{$customer->email}}</td>
                        @if($customer->city_id)
                            <td>{{$customer->city->name}}</td>
                        @else
                            <td>Chưa có thành phố</td>
                        @endif
                        <td><a href="{{route('customers.edit',$customer->id)}}">Sửa</a></td>
                        <td><a href="{{route('customers.destroy',$customer->id)}}">Xóa</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Không có dữ liệu</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-primary" href={{route('customers.create')}}>Thêm mới</a>
                    </div>
                    <div class="col-6">
                        <div class="pagination float-right">
                            {{ $customers->appends(request()->query()) }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
{{--        Modal--}}
        <div class="modal fade" id="cityModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <form action="{{ route('customers.filterByCity') }}" method="get">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <!--Lọc theo khóa học -->
                            <div class="select-by-program">
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label border-right">Lọc khách hàng theo tỉnh
                                        thành</label>
                                    <div class="col-sm-7">
                                        <select class="custom-select w-100" name="city_id">
                                            <option value="" disabled>Chọn tỉnh thành</option>
                                            @foreach($cities as $city)
                                                @if(isset($cityFilter))
                                                    @if($city->id == $cityFilter->id)
                                                        <option value="{{$city->id}}" selected>{{ $city->name }}</option>
                                                    @else
                                                        <option value="{{$city->id}}">{{ $city->name }}</option>
                                                    @endif
                                                @else
                                                    <option value="{{$city->id}}">{{ $city->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- </form> -->
                            </div>
                            <!--End-->

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submitAjax" class="btn btn-primary">Chọn</button>
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
