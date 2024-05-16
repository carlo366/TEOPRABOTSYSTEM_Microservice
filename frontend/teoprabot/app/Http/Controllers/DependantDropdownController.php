<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DependantDropdownController extends Controller
{
    public function provinces()
    {
        return \Indonesia::allProvinces();
    }

    public function cities(Request $request)
    {
        return \Indonesia::findProvince($request->id, ['cities'])->cities->pluck('name', 'id');
    }

    public function districts(Request $request)
    {
        return \Indonesia::findCity($request->id, ['districts'])->districts->pluck('name', 'id');
    }

    public function villages(Request $request)
    {
        return \Indonesia::findDistrict($request->id, ['villages'])->villages->pluck('name', 'id');
    }

    public function index()
    {
        // Di sini Anda dapat memanggil metode provinces() jika dibutuhkan
        $provinces = $this->provinces(); // Contoh, sesuaikan dengan kebutuhan Anda

        return view('dependent-dropdown', compact('provinces'));
    }
}
