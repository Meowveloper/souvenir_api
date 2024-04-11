<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //TODO user login and release token
    // public function authenticate(Request $request)
    // {
    //     //email, password
    //     $user = User::where('email', '=', $request->email)->first();

    //     if (isset($user)) {
    //         if (Hash::check($request->password, $user->password)) {
    //             return response()->json([
    //                 'user' => $user,
    //                 'token' => $user->createToken(time())->plainTextToken
    //             ]);
    //         } else {
    //             dd('wrong password');
    //         }
    //     } else {
    //         return response()->json([
    //             'user' => null,
    //             'token' => null
    //         ]);
    //     }
    // }

    public function authenticate(Request $request) {
        $user = User::where('email', '=', $request->email)->first();

        if(isset($user)) {
            if(Hash::check($request->password, $user->password)) {
                return response()->json([
                    'loginStatus' => true,
                    'user' => $user,
                    'token' => $user->createToken(time())->plainTextToken
                ]);
            } else {
                return response()->json([
                    'loginStatus' => false,
                    'user' => null,
                    'token' => null
                ]);
            }
        } else{
            return response()->json([
                'loginStatus' => null,
                'user' => null,
                'token' => null
            ]);
        }
    }

    public function update(Request $request) {

        User::where('id', '=', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);



        return response()->json([
            'status' => 'success'
        ]);
    }

    public function changePassword(Request $request) {

        $oldPassword = User::where('id', '=', $request->id)->first()->password;
        if(Hash::check($request->oldPassword, $oldPassword)) {
            User::where('id', '=', $request->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            return response()->json([
                'status' => 'success'
            ]);


        } else{
            return response()->json([
                'status' => 'failed'
            ]);
        }
    }
}
