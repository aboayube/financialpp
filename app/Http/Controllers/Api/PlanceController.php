<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class PlanceController extends Controller
{
    public function storePlance(Request $request, $lang)
    {
        $this->set_Language($lang);
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required',
            'plance' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'data' =>  $validator->errors(), 'status' => 200]);
        }
        $user = User::where('id', auth()->id())->first();
        $user->update([
            'total' => $request->plance + $user->total,
        ]);
        $user->payment()->create([
            'plance' => $request->post('plance'),
            'bank_id' => $request->post('bank_id'),
        ]);

        return response()->json(['error' => false, 'data' => new UserResource($user), "status" => 200]);
    }
}
