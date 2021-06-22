<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('cities.list', compact('cities'));
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
    {
        $city = new City();
        $city->name = $request->input('name');
        $city->save();
        Session::flash('success', "Tạo thành phố thành công");
        return redirect()->route('cities.index');
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('cities.edit', compact('city'));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->name = $request->input('name');
        $city->save();
        Session::flash('success', 'Sửa thành phố thành công');
        return redirect()->route('cities.index');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $city = City::findOrFail($id);
            $city->customers()->update(['city_id'=>null]);
            $city->delete();
            Session::flash('success', 'Xóa thành phố thành công');
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            echo $exception->getMessage();
        }

        return redirect()->route('cities.index');
    }
}

