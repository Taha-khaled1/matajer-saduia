<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Traits\ImageProcessing;

class SubCatogeryController extends Controller
{
               
   function __construct()
    {
         $this->middleware('permission:جميع الاقسام الفرعيه', ['only' => ['index','updateStatusCatogery']]);
         $this->middleware('permission:اضافة الاقسام الفرعيه', ['only' => ['store']]);
         $this->middleware('permission:تعديل الاقسام الفرعيه', ['only' => ['update']]);
         $this->middleware('permission:حذف الاقسام الفرعيه', ['only' => ['destroy']]);
    }
    use ImageProcessing;

    public function index()
    {
        $subcategories = SubCategory::orderByDesc('created_at')->with('category')->get();
        $categories = Category::all();

        return view('dashboard.subcatogery.index', compact('subcategories','categories'));
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

 
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|unique:sub_categories|max:100',
            'name_ar' => 'required|unique:sub_categories|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'boolean',
            'category_id' => 'required|integer|exists:categories,id', // category id /id
        ], [
            'name_en.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name_en.unique' => 'اسم الفئة باللغة الإنجليزية مُسجل مسبقًا',
            'name_en.max' => 'يجب ألا يتجاوز اسم الفئة باللغة الإنجليزية 100 حرف',
            'name_ar.required' => 'يرجى إدخال اسم الفئة باللغة العربية',
            'name_ar.unique' => 'اسم الفئة باللغة العربية مُسجل مسبقًا',
            'name_ar.max' => 'يجب ألا يتجاوز اسم الفئة باللغة العربية 100 حرف',
            'image.image' => 'يرجى اختيار صورة صالحة',
            'image.mimes' => 'صيغ الصور المدعومة هي: jpeg, png, jpg, gif, svg',
            'status.boolean' => 'قيمة حالة الفئة يجب أن تكون صحيحة أو خاطئة',
        ]);

        if ($validator->fails()) {
            session()->flash('Erorr', 'لم يتم الحفظ  بسبب مشكله ما');

            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['image'] = $this->saveImage($request->file('image'), 'subcategory');
        $sub_category = new SubCategory;
        $sub_category->name_en = $request->input('name_en');
        $sub_category->name_ar = $request->input('name_ar');
        $sub_category->image =  'imagesfp/subcategory/' . $data['image'];
        $sub_category->status = $request->input('status', true);
        $sub_category->category_id = $request->input('category_id'); // category id
        $sub_category->save();
        session()->flash('Add', 'تم اضافة القسم الفرعي بنجاح ');

        return redirect()->route('subcategories.index')->with('success', 'Category created successfully');
    }

    public function updateStatusCatogery(Request $request)
    {
        $isToggleOnString = (string) $request->isToggleOn;
        $status = true;
        $subCategoryId = $request->input('subCategoryId');
        if ($isToggleOnString == "true") {
            $status = true;
        } else {
            $status = false;
        }



        $subCategory = SubCategory::find($subCategoryId);

        if ($subCategory) {
            // Update the status field
            $subCategory->status = $status;
            $subCategory->save();

            return response()->json(['success' => true, 'message' => 'sub category status  updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'sub category not found'.$subCategoryId]);
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
        // return $request;
        
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|max:100|unique:sub_categories,name_en,' . $request->id . ',id',
            'name_ar' => 'required|max:100|unique:sub_categories,name_ar,' . $request->id . ',id',
            'image' => 'nullable|image',
            'status' => 'boolean',      
            'category_id' => 'required|integer|exists:categories,id', // category_id / id

            // 'arrange' => 'integer',
        ], [
            'name_en.required' => 'يرجى إدخال اسم الفئة باللغة الإنجليزية',
            'name_en.max' => 'يجب أن يكون طول اسم الفئة باللغة الإنجليزية حتى 100 حرف',
            'name_en.unique' => 'اسم الفئة باللغة الإنجليزية مسجل بالفعل',
            'name_ar.required' => 'يرجى إدخال اسم الفئة باللغة العربية',
            'name_ar.max' => 'يجب أن يكون طول اسم الفئة باللغة العربية حتى 100 حرف',
            'name_ar.unique' => 'اسم الفئة باللغة العربية مسجل بالفعل',
            'image.image' => 'يجب أن تكون الصورة من نوع صورة',
            'status.boolean' => 'حالة الفئة يجب أن تكون صحيحة أو خاطئة',
            // 'arrange.integer' => 'الترتيب يجب أن يكون عددًا صحيحًا',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = SubCategory::findOrFail($request->id);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('image')) {
            // Delete the existing image
            $this->deleteImage($category->image);

            // Save the new image
            $data['image'] =  $this->saveImage($request->file('image'), 'subcategory');
            $data['image'] = 'imagesfp/subcategory/' . $data['image'];
        }
        $category->category_id = $request->category_id;
        $category->update($data);
        $category->save();
        session()->flash('Add', 'تم تحديث بيانات القسم الفرعي بنجاح ');
        return redirect()->route('subcategories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Request $request)
    {
        $category = SubCategory::find($request->id);

        // Delete the associated image
        $this->deleteImage($category->image);

        // Delete the category
        $category->delete();
        session()->flash('delete', 'تم حذف القسم الفرعي بنجاح ');
        return redirect()->route('subcategories.index')->with('success', 'Category deleted successfully');
    }
    public function delete(Request $request)
    {
        return $request;
    }
}