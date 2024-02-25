<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $userdata = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->orderBy('id', 'DESC')
            ->with('roles')
            ->get();
        $roles = Role::all();
        return view('dashboard.user.index', compact('userdata', 'roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }




    public function affiliateMarketer(Request $request)
    {



        $userdata = User::whereHas('roles', function ($query) {
            $query->where('name', 'affiliate');
        })->orderBy('id', 'DESC')
            ->with('roles')
            ->get();

        $roles = Role::all();

        return view('dashboard.user.index', compact('userdata', 'roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function vendeors(Request $request)
    {
        $userdata = User::whereHas('roles', function ($query) {
            $query->where('name', 'vendor');
        })->orderBy('id', 'DESC')
            ->with('roles')
            ->get();

        $roles = Role::all();

        return view('dashboard.user.index', compact('userdata', 'roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function userUpdate($id)
    {
        $roles = Role::all();
        $user = User::with('roles')->find($id);

        return view('dashboard.user.update-user', compact('user', 'roles'));
    }
    public function chargeWallet(Request $request)
    {
        // return $request;
        $user = User::find($request->user_id);
        $user->refund = $request->money;
        $user->save();
        session()->flash('Add', 'تم شحن محفظة المستخدم بنجاح');
        return back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $isToggleOnString = (string) $request->isToggleOn;
        $status = '';
        $userId = $request->input('userId');
        if ($isToggleOnString == "true") {
            $status = 1;
        } else {
            $status = 0;
        }



        $user = User::find($userId);

        if ($user) {
            // Update the status field
            $user->status = $status;
            $user->save();

            return response()->json(['success' => true, 'message' => 'User status  updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'User not found']);
    }

    public function disableCashOnDelivery(Request $request)
    {
        $isToggleOnString = (string) $request->isToggleOn;
        $status = '';
        $userId = $request->input('userId');
        if ($isToggleOnString == "true") {
            $status = 1;
        } else {
            $status = 0;
        }



        $user = User::find($userId);

        if ($user) {
            // Update the status field
            $user->cash_on_delivery = $status;
            $user->save();

            return response()->json(['success' => true, 'message' => 'User status  updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'User not  found']);
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'email:rfc,dns', 'indisposable'],
            'password' => 'required|string|min:8',
        ];
        $validatedData = $request->validate($rules);
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();
        $user->assignRole($request->input('roles'));
        session()->flash('Add', 'تم اضافة المستخدم بنجاح');
        return back();
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


    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }


    public function update(Request $request)
    {
        // return $request;
        $rules = [
            'pro_id' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'phone' => 'nullable|numeric',
            'email' => 'required|email|max:255|unique:users,email,' . $request->pro_id,
            'password' => 'nullable|min:8|max:255',
            'roles' => 'required|array',
        ];

        $validatedData = $request->validate($rules);

        $id = $request->pro_id;
        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->phone = $validatedData['phone'];
        $user->email = $validatedData['email'];
        $user->email_verified_at = now();
        if ($validatedData['password']) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->save();

        // DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->roles()->sync($validatedData['roles']);

        session()->flash('Edit', 'تم تعديل المستخدم بنجاح');
        return back()->with('success', 'User updated successfully');
    }


    public function destroy(Request $request)
    {

        $property = User::findOrFail($request->pro_id);
        $property->delete();
        session()->flash('delete', 'تم حذف المستخدم بنجاح');
        return back();
    }
}
