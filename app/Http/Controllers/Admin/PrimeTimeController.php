<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PrimeTimeController extends Controller
{
    public function index(Request $request, $company)
    {
        $company = Company::findOrFail($company);
        return view('back.company.prime_time', compact('company'));
    }

    public function save(Request $request, $company)
    {
        $model = Company::findOrFail($company);
        $model->prime_time = $request->get('prime_time', 0);
        $model->save();
        return redirect()->back()->with('message', 'Prime Time saved successfully');
    }
}
