<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Advertisement;
use App\Traits\ImageProcessing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    use ImageProcessing;

    public function index()
    {
        $advertisements = Advertisement::orderByDesc('created_at')->get();
        return view('dashboard.advertisement.index', compact('advertisements'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:advertisements|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'boolean',
        ], [
            'name.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name.unique' => 'اسم الفئة باللغة الإنجليزية مُسجل مسبقًا',
            'name.max' => 'يجب ألا يتجاوز اسم الفئة باللغة الإنجليزية 100 حرف',
            'image.image' => 'يرجى اختيار صورة صالحة',
            'image.mimes' => 'صيغ الصور المدعومة هي: jpeg, png, jpg, gif, svg',
            'status.boolean' => 'قيمة حالة الفئة يجب أن تكون صحيحة أو خاطئة',
        ]);

        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ الاعلان بسبب مشكله ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['image'] = $this->saveImage($request->file('image'), 'category');
        $category = new Advertisement;
        $category->name = $request->input('name');
        $category->image =  'imagesfp/category/' . $data['image'];
        // $category->status = $request->input('status', true);
        $category->link = $request->input('link');
        $category->product_id = $request->input('product_id', 1);
        $category->save();
        session()->flash('Add', 'تم اضافة الاعلان بنجاح ');

        return redirect()->route('advertisements.index')->with('success', 'Category created successfully');
    }

    public function updateStatusCatogery(Request $request)
    {
        $isToggleOnString = (string) $request->isToggleOn;
        $status = true;
        $categoryId = $request->input('categoryId');
        if ($isToggleOnString == "true") {
            $status = true;
        } else {
            $status = false;
        }



        $category = Advertisement::find($categoryId);

        if ($category) {
            // Update the status field
            $category->status = $status;
            $category->save();

            return response()->json(['success' => true, 'message' => 'category status  updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'category not found']);
    }
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:advertisements,name,' . $request->id . ',id',
            'name_ar' => 'required|max:100|unique:advertisements,name_ar,' . $request->id . ',id',
            'image' => 'nullable|image',
            'status' => 'boolean',
            'arrange' => 'integer',
        ], [
            'name.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name.max' => 'يجب أن يكون طول اسم الفئة باللغة الإنجليزية حتى 100 حرف',
            'name.unique' => 'اسم الفئة باللغة الإنجليزية مسجل بالفعل',
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
        $category = Advertisement::findOrFail($request->id);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('image')) {
            // Delete the existing image
            $this->deleteImage($category->image);

            // Save the new image
            $data['image'] =  $this->saveImage($request->file('image'), 'category');
            $data['image'] = 'imagesfp/category/' . $data['image'];
        }

        $category->update($data);
        session()->flash('Add', 'تم تحديث بيانات الاعلان بنجاح ');
        return redirect()->route('advertisements.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Request $request)
    {
        $category = Advertisement::find($request->id);

        // Delete the associated image
        $this->deleteImage($category->image);

        // Delete the category
        $category->delete();
        session()->flash('delete', 'تم حذف الاعلان ');
        return redirect()->route('advertisements.index')->with('success', 'Category deleted successfully');
    }
    public function delete(Request $request)
    {
        return $request;
    }
}
