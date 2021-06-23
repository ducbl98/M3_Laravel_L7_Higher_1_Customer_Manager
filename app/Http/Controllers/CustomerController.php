<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\City;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $customers = Customer::paginate(3);
        $cities=City::all();
        return  view('customers.list',compact('customers','cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $cities=City::all();
        return view('customers.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     */
    public function store(AddCustomerRequest $request): \Illuminate\Http\RedirectResponse
    {
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->dob = $request->input('dob');
        $customer->email = $request->input('email');
        $customer->city_id=$request->input('city_id');
        $customer->save();
        Session::flash('success','Tạo khách hàng thành công');
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities=City::all();
        $customer =Customer::findOrFail($id);
        return view('customers.edit',compact('customer','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer =Customer::findOrFail($id);
        $customer->name =$request->input('name');
        $customer->dob =$request->input('dob');
        $customer->email =$request->input('email');
        $customer->city_id=$request->input('city_id');
        $customer->save();
        Session::flash('success','Sửa khách hàng thành công');
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer=Customer::findOrFail($id);
        $customer->delete();
        Session::flash('success','Xóa khách hàng thành công');
        return redirect()->route('customers.index');
    }

    public function filterByCity(Request $request)
    {
        $idCity=$request->input('city_id');
        $cityFilter =City::findOrFail($idCity);
        $customers=Customer::where('city_id',$cityFilter->id)->get();
        $totalCustomerFilter = count($customers);
        $cities=City::all();
        return view('customers.list',compact('customers','cities','totalCustomerFilter','cityFilter'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        if(!$keyword){
            return redirect()->route('customers.index');
        }
        $customers=Customer::where('name','LIKE','%'.$keyword.'%')->paginate(3);
        $cities=City::all();
        return view('customers.list',compact('customers','cities'));
    }
}
