<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\BranchCompany;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ImageProcessing;
use Illuminate\Support\Facades\Auth;

class BranchCompanyController extends Controller
{

    function __construct()
    {
        // $this->middleware('permission:جميع الاقسام', ['only' => ['index', 'updateStatusCatogery']]);
        // $this->middleware('permission:اضافة قسم', ['only' => ['store']]);
        // $this->middleware('permission:تعديل قسم', ['only' => ['update']]);
        // $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
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
            'adress' => 'required|max:100',
            'phone' => 'required|max:100',
            'street' => 'required|max:100',
            'zip' => 'required|max:100',
            'region' => 'required|max:100',

        ]);

        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ فرع الشركه بسبب مشكله ما');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $existingBranchesCount = BranchCompany::count();

        // If this is the first branch, set it as default
        $data = $validator->validate();
        if ($existingBranchesCount == 0) {
            $data['status'] = true;
        }
        $data['user_id'] = Auth::user()->id;
        $b = BranchCompany::create($data);


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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'sometimes|max:100',
            'country' => 'sometimes|max:100',
            'city' => 'sometimes|max:100',
            'description_ar' => 'sometimes|max:100',
            'phone' => 'sometimes|max:100',
            'street' => 'sometimes|max:100',
            'zip' => 'sometimes|max:100',
            'region' => 'sometimes|max:100',

        ]);

        if ($validator->fails()) {
            session()->flash('delete', 'لم يتم حفظ فرع الشركه بسبب مشكله ما');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = BranchCompany::findOrFail($request->id);
        $data = $request->except(['_token', '_method']);
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

    public function setDefaultAddress(Request $request)
    {

        $user = User::find(Auth::user()->id); // Auth::user();
        $address = BranchCompany::findOrFail($request->addressId);

        // Unset default flag for previous default address, if exists
        $user->addressesCompany()->where('status', true)->update(['status' => false]);

        // Set the new default address
        $address->status = true;
        $address->save();

        session()->flash('Add', 'تم تحديث بيانات نقطة الاستلام بنجاح ');

        return redirect()->route('branch_companies.index')->with('success', 'Category created successfully');
    }
}
