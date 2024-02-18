<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Country;
use Monarobase\CountryList\CountryListFacade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:الدول و الضرائب', ['only' => ['index', 'store', 'show', 'edit', 'update', 'destroy']]);
        //  $this->middleware('permission:اعدادت الهدايا', ['only' => ['gift','updateGift']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countriesListen = CountryListFacade::getList('en');
        $countriesListar = CountryListFacade::getList('ar');
        $countries = Country::all();
        return view('dashboard.country.index', compact('countries', 'countriesListen','countriesListar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:countries|max:255', 
            'name_en' => 'required|unique:countries|max:255',
            'country_tax' => [
                'nullable',
                'numeric',
                'between:0,999999.9'
            ],

        ], [

            'name.required' => 'يرجي ادخال اسم الدوله',
            'name.unique' => 'اسم الدوله مسجل مسبقا',
            'country_tax.numeric' => 'يرجي ادخال رقم',

        ]);
        // return $request;

        $datacountry = new Country();
        $datacountry->name = $request->name;
        $datacountry->name_en = $request->name_en;
        $datacountry->latitude = $request->latitude;
        $datacountry->longitude = $request->longitude;
        $datacountry->country_tax = $request->country_tax;
        $datacountry->save();
        session()->flash('Add', 'تم اضافة الدوله بنجاج');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $validatedData = $request->validate([
            'name' => 'required|unique:countries,name,' . $id . '|max:100',
            'country_tax' => [
                'nullable',
                'numeric',
                'between:0,999999.9'
            ],

        ], [

            'name.required' => 'يرجي ادخال اسم الدوله',
            'name.unique' => 'اسم الدوله مسجل مسبقا',
            'country_tax.numeric' => 'يرجي ادخال رقم',

        ]);

        $sections = Country::findOrFail($id);


        $sections->update([
            'name' => $request->name,
            'country_tax' => $request->country_tax,
        ]);

        session()->flash('edit', 'تم تعديل الدوله بنجاج');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $country = Country::findorFail($id);
        $country->delete();
        session()->flash('delete', 'تم حذف الدوله بنجاح');
        return back();
    }
}