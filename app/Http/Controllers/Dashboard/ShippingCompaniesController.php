<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ShippingCompanies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShippingCompaniesController extends Controller
{
    public function index()
    {
        $shipping_companies = ShippingCompanies::orderByDesc('created_at')->where("user_id", Auth::user()->id)->get();
        return view('dashboard.shipping_companies.index', compact('shipping_companies'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'name_en' => 'required|unique:shipping_companies|max:100',
            'name_ar' => 'required|unique:shipping_companies|max:100',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'status' => 'boolean',
            'cost' => 'required',
        ], [
            // 'name_en.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            // 'name_en.unique' => 'اسم الفئة باللغة الإنجليزية مُسجل مسبقًا',
            // 'name_en.max' => 'يجب ألا يتجاوز اسم الفئة باللغة الإنجليزية 100 حرف',
            'name_ar.required' => 'يرجى إدخال اسم الفئة باللغة العربية',
            'name_ar.unique' => 'اسم الفئة باللغة العربية مُسجل مسبقًا',
            // 'name_ar.max' => 'يجب ألا يتجاوز اسم الفئة باللغة العربية 100 حرف',
            // 'image.image' => 'يرجى اختيار صورة صالحة',
            // 'image.mimes' => 'صيغ الصور المدعومة هي: jpeg, png, jpg, gif, svg',
            // 'status.boolean' => 'قيمة حالة الفئة يجب أن تكون صحيحة أو خاطئة',
            // 'arrange.integer' => 'قيمة ترتيب الفئة يجب أن تكون عددًا صحيحًا',
        ]);

        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ شركة الشحن بسبب مشكله ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = new ShippingCompanies;
        $category->name_ar = $request->input('name_ar');
        $category->cost = $request->input('cost');
        $category->user_id = Auth::user()->id;
        $category->save();
        session()->flash('Add', 'تم اضافة شركة الشحن بنجاح ');

        return back();
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|max:100|unique:shipping_companies,name_ar,' . $request->id . ',id',

        ],);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = ShippingCompanies::findOrFail($request->id);

        $data = $request->except(['_token', '_method']);
        $category->update($data);
        session()->flash('Add', 'تم تحديث بيانات شركة الشحن بنجاح ');
        return back();
    }

    public function destroy(Request $request)
    {
        $category = ShippingCompanies::find($request->id);
        $category->delete();
        session()->flash('delete', 'تم حذف شركة الشحن ');
        return back();
    }
}
