<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\BranchCompany;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ImageProcessing;

class BranchCompanyController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:جميع الاقسام', ['only' => ['index', 'updateStatusCatogery']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }
    use ImageProcessing;

    public function index()
    {
        $branch_companies = BranchCompany::orderBy('arrange')->orderByDesc('created_at')->get();
        return view('dashboard.branch.index', compact('branch_companies'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|max:100',
            'country' => 'required|max:100',
            'city' => 'required|max:100',
            'description_ar' => 'required|max:100',
            'arrange' => 'integer',
        ]);

        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ فرع الشركه بسبب مشكله ما');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = new BranchCompany;
        $category->country = $request->input('country');
        $category->name_ar = $request->input('name_ar');
        $category->city =  $request->city;
        $category->description_ar =  $request->description_ar;
        $category->arrange = $request->input('arrange', 1);
        $category->save();
        session()->flash('Add', 'تم اضافة فرع الشركه بنجاح ');

        return redirect()->route('branch_companies.index')->with('success', 'Category created successfully');
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



        $category = BranchCompany::find($categoryId);

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
        $category = BranchCompany::findOrFail($request->id);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('image')) {
            // Delete the existing image
            $this->deleteImage($category->image);

            // Save the new image
            $data['image'] =  $this->saveImage($request->file('image'), 'category');
            $data['image'] = 'imagesfp/category/' . $data['image'];
        }

        $category->update($data);
        session()->flash('Add', 'تم تحديث بيانات فرع الشركه بنجاح ');
        return redirect()->route('branch_companies.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Request $request)
    {
        $category = BranchCompany::find($request->id);

        // Delete the associated image
        $this->deleteImage($category->image);

        // Delete the category
        $category->delete();
        session()->flash('delete', 'تم حذف فرع الشركه ');
        return redirect()->route('branch_companies.index')->with('success', 'Category deleted successfully');
    }
}
