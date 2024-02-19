<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WithdrawalMangmentController extends Controller
{
  
    public function index()
    {
          $withdrawals=  Withdrawal::all();
            return view('dashboard.withdrawal-mangment.index', compact('withdrawals'));
        
    }


    public function changeType(Request $request)
    {
        $withdrawal = Withdrawal::find($request->id);
        $withdrawal->type = $request->type;
        $withdrawal->save();   session()->flash('Add', 'تم تغيير الحاله بنجاح');

           return redirect()->route('withdrawals.mangment')->with('success', 'withdrawal created successfully');
    }


    public function store(Request $request)
    {
        //    $rules = [
        //         'price' => 'required|numeric|between:0,999999.99|main:1',
        //     ];

        // // Validate the request with the rules
        //     $validator = Validator::make($request->all(), $rules);

        //     if ($validator->fails()) {
        //         return redirect()->back()->withErrors($validator)->withInput();
        //     }
            $withdrawal = new Withdrawal;
            $withdrawal->total = $request->input('price');
            $withdrawal->type =  "suspended";
            $withdrawal->user_id = Auth::user()->id;
            // $withdrawal->id = md5(uniqid('', true));
            $withdrawal->save();
            session()->flash('Add', 'تم طلب السحب بانتظار الموافقه ... ');

           return redirect()->route('withdrawals')->with('success', 'withdrawal created successfully');
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function show(Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Withdrawal  $withdrawal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Withdrawal $withdrawal)
    {
        //
    }

   
    public function destroy(Request $request)
    {
        // return $request;
        $withdrawal = Withdrawal::find($request->id);
        $withdrawal->delete();
        session()->flash('delete', '  تم الحذف  ');
     return redirect()->route('withdrawals.mangment')->with('success', 'withdrawal created successfully');
    }
}