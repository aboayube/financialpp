<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class RegisterUserController extends Controller
{

    public function login(Request $request, $lang)
    {
        $this->set_Language($lang);

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'data' => $validator->errors(), 'status' => 200]);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('my-app-token')->plainTextToken;
            return response()->json(['error' => false, 'data' => $data, "status" => 200]);
        } else {
            return response()->json(['error' => false, 'data' => 'there is errors', "status" => 200]);
        } //end of else

    }
    //
    public function register(Request $request, $lang)
    {
        $this->set_Language($lang);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string',
            'name_en' => 'required|min:3|string',

            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|numeric|min:10',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'true', 'message' => $validator->errors()->first(), 'status' => 200]);
        }

        $user = User::create([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => 'user',
        ]);
        $data['user'] = new UserResource($user);
        $data['token'] = $user->createToken('my-app-token')->plainTextToken;

        return response()->json(['error' => false, 'data' => $data, 'status' => 200], 200);
    }
}
