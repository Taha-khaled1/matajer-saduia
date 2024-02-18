<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CouponController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:جميع القسائم', ['only' => ['index']]);
         $this->middleware('permission:اضافة قسيمه', ['only' => ['store']]);
         $this->middleware('permission:تعديل قسيمه', ['only' => ['update']]);
         $this->middleware('permission:حذف قسيمه', ['only' => ['destroy']]);
    }
    public function index()
    {
        $coupons = Coupon::all();
        return view('dashboard.coupon.index', compact('coupons'));
    }

 


    
    public function create()
    {
     
        return view('dashboard.coupon.store');
    }

  
    public function store(Request $request)
    {
        // return $request;
        
        $validatedData = $request->validate([
            'code' => 'required|unique:coupons',
            'discount_amount' => 'required|numeric',
            // 'category_id' => 'nullable|exists:categories,id',
            // 'sub_category_id' => 'nullable|exists:sub_categories,id',
            // 'apply_to_all' => 'boolean',
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'user_id' => 'exists:users,id',
        ], [
            'code.required' => 'حقل الكود مطلوب', 
            'type.required' => 'حقل نوع القسيمه مطلوب',
            'code.unique' => 'قيمة الكود موجودة مسبقاً',
            'discount_amount.required' => 'حقل مبلغ الخصم مطلوب',
            'discount_amount.numeric' => 'حقل مبلغ الخصم يجب أن يكون رقمي',
            'start_date.required' => 'حقل تاريخ البدء مطلوب',
            'start_date.date' => 'حقل تاريخ البدء يجب أن يكون تاريخاً',
            'end_date.required' => 'حقل تاريخ الانتهاء مطلوب',
            'end_date.date' => 'حقل تاريخ الانتهاء يجب أن يكون تاريخاً',
            'end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء',
            'user_id.exists' => 'رقم المستخدم غير موجود'
        ]);

        $coupon =new Coupon();
        $coupon->code = $validatedData['code'];
        $coupon->discount_amount = $validatedData['discount_amount'];
        $coupon->type = $validatedData['type'];
        $coupon->start_date = $validatedData['start_date'];
        $coupon->end_date = $validatedData['end_date'];
        $coupon->save();
        // Coupon::create($validatedData);

       session()->flash('Add', 'تم اضافة القسيمه بنجاح ');
       return redirect()->route('coupons')->with('success', 'Coupon created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $validatedData = $request->validate([
        'code' => 'required|unique:coupons,code,' . $request->id,
        'discount_amount' => 'required|numeric',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
       
    ]);

        $coupon = Coupon::find($request->id); // حدد القسيمة التي تريد تحديثها
        $coupon->update($validatedData);
         session()->flash('Add', 'تم تعديل القسيمه بنجاح ');
        return redirect()->route('coupons')->with('success', 'Coupon updated successfully.');
    }


    public function destroy(Request $request)
    {
        $coupon = Coupon::find($request->id);
        $coupon->delete();
        session()->flash('delete', 'تم حذف القسيمه بنجاح ');
        return redirect()->route('coupons')->with('success', 'color deleted successfully');
    }
}