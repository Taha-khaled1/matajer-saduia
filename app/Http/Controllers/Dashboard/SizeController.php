<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SizeController extends Controller
{

   function __construct()
    {
         $this->middleware('permission:الاحجام', ['only' => ['index']]);
         $this->middleware('permission:اضافة حجم', ['only' => ['store']]);
         $this->middleware('permission:تعديل حجم', ['only' => ['update']]);
         $this->middleware('permission:حذف حجم', ['only' => ['destroy']]);
    }
        public function index()
    {
        $sizes = Size::all();
        return view('dashboard.size.index', compact('sizes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|unique:sizes|max:100',
            'name_ar' => 'required|unique:sizes|max:100',

        ], [
            'name_en.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name_en.unique' => 'اسم الفئة باللغة الإنجليزية مُسجل مسبقًا',
            'name_en.max' => 'يجب ألا يتجاوز اسم الفئة باللغة الإنجليزية 100 حرف',
            'name_ar.required' => 'يرجى إدخال اسم الفئة باللغة العربية',
            'name_ar.unique' => 'اسم الفئة باللغة العربية مُسجل مسبقًا',
            'name_ar.max' => 'يجب ألا يتجاوز اسم الفئة باللغة العربية 100 حرف',

        ]);

        if ($validator->fails())
        {
            session()->flash('delete', 'لم يتم الحفظ  بسبب مشكله ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $size = new Size;
        $size->name_en = $request->input('name_en');
        $size->name_ar = $request->input('name_ar');
        $size->save();
        session()->flash('Add', 'تم الاضافه بنجاح ');

        return redirect()->route('sizes.index')->with('success', 'size created successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|max:100|unique:sizes,name_en,' . $request->id . ',id',
            'name_ar' => 'required|max:100|unique:sizes,name_ar,' . $request->id . ',id',
        ], [
            'name_en.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name_en.max' => 'يجب أن يكون طول اسم الفئة باللغة الإنجليزية حتى 100 حرف',
            'name_en.unique' => 'اسم الفئة باللغة الإنجليزية مسجل بالفعل',
            'name_ar.required' => 'يرجى إدخال اسم الفئة باللغة العربية',
            'name_ar.max' => 'يجب أن يكون طول اسم الفئة باللغة العربية حتى 100 حرف',
            'name_ar.unique' => 'اسم الفئة باللغة العربية مسجل بالفعل',

        ]);


        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $size = Size::findOrFail($request->id);

        $data = $request->except(['_token', '_method']);


        $size->update($data);
        session()->flash('Add', 'تم تحديث البيانات  بنجاح ');
        return redirect()->route('sizes.index')->with('success', 'size updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $size = size::find($request->id);




        $size->delete();
        session()->flash('delete', 'تم الحذف بنجاح ');
        return redirect()->route('sizes.index')->with('success', 'size deleted successfully');
    }
}