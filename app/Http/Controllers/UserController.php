<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WarehouseUser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200', 'confirmed'],
            'contact_number' => ['required','string','regex:/^0[0-9]{10}$/',Rule::unique('users', 'contact_number')],
        ]);

        $validator->validateWithBag('register'); 

        $validatedData = $validator->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        // Optionally log in
        auth()->guard()->login($user);

        return redirect(route('/'));
    }

    public function admin_updateRole(Request $request, $user_id){
        $user = User::findOrFail($user_id);
        $name = $user->name;
        $user->update($request->only('role'));
        return back()->with('success', $name. ' role updated successfully.');
    }

    public function admin_updateWarehouse(Request $request, $user_id){
        $user = User::findOrFail($user_id);
        WarehouseUser::updateOrCreate([
            'user_id' => $request->user_id,
        ],[
            'warehouse_id' => $request->warehouse_id,
        ]);

        return back()->with('success', ' User warehouse assignment updated successfully.');
    }

    public function admin_deleteWarehouse($user_id){
        $warehouseuser = WarehouseUser::where('user_id',$user_id)->first();
        if($warehouseuser) {
            $warehouseuser->delete();
        } else {
            return back()->withErrors('User warehouse assignment not set.');
        }
        
        return back()->with('success', ' User warehouse assignment deleted successfully.');   
    }

    public function admin_destroy($user_id)
    {
        $user = User::findOrFail($user_id);
        $name = $user->name;
        $user->delete();
        return back()->with('success', $name.' removed successfully.');
    }
}
