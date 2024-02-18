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
        $shipping_companies = ShippingCompanies::orderByDesc('created_at')->get();
        return view('dashboard.shipping_companies.index', compact('shipping_companies'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'name_en' => 'required|unique:categories|max:100',
            'name_ar' => 'required|unique:categories|max:100',
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
            session()->flash('delete', 'لم يتم حفظ القسم بسبب مشكله ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = new ShippingCompanies;
        $category->name_ar = $request->input('name_ar');
        $category->cost = $request->input('cost');
        $category->user_id = Auth::user()->id;
        $category->save();
        session()->flash('Add', 'تم اضافة القسم بنجاح ');

        return redirect()->route('shipping_companies')->with('success', 'Category created successfully');
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|max:100|unique:categories,name_en,' . $request->id . ',id',
            'name_ar' => 'required|max:100|unique:categories,name_ar,' . $request->id . ',id',
            'image' => 'nullable|image',
            'status' => 'boolean',
            'arrange' => 'integer',
        ], [
            'name_en.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name_en.max' => 'يجب أن يكون طول اسم الفئة باللغة الإنجليزية حتى 100 حرف',
            'name_en.unique' => 'اسم الفئة باللغة الإنجليزية مسجل بالفعل',
            'name_ar.required' => 'يرجى إدخال اسم الفئة باللغة العربية',
            'name_ar.max' => 'يجب أن يكون طول اسم الفئة باللغة العربية حتى 100 حرف',
            'name_ar.unique' => 'اسم الفئة باللغة العربية مسجل بالفعل',
            'image.image' => 'يجب أن تكون الصورة من نوع صورة',
            'status.boolean' => 'حالة الفئة يجب أن تكون صحيحة أو خاطئة',
            'arrange.integer' => 'الترتيب يجب أن يكون عددًا صحيحًا',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = Category::findOrFail($request->id);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('image')) {
            // Delete the existing image
            $this->deleteImage($category->image);

            // Save the new image
            $data['image'] =  $this->saveImage($request->file('image'), 'category');
            $data['image'] = 'imagesfp/category/' . $data['image'];
        }

        $category->update($data);
        session()->flash('Add', 'تم تحديث بيانات القسم بنجاح ');
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Request $request)
    {
        $category = ShippingCompanies::find($request->id);
        $category->delete();
        session()->flash('delete', 'تم حذف القسم ');
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
