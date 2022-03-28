<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{

    public function index()
    {
        $income = Income::orderBy('id', 'DESC')->with(['bank', 'category', 'user'])->where('user_id', auth()->id())->paginate(10);

        if ($income->count() > 0) {
            return response()->json(['error' => false, 'data' => IncomeResource::collection($income), 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'message' => 'No transaction found', 'status' => 200],);
        }
    }
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'type_name' => 'required',
            'type_expense' => 'required',
            'category_id' => 'required',
            'amount' => 'required',
            'bank_id' => 'required',
            'type_expense' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => true, 'message' => $validation->errors()], 200);
        }


        $cats = auth()->user()->income()->create([
            'type_name' => $request->type_name,
            'type_expense' => $request->type_expense,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'bank_id' => $request->bank_id,
            'duration' => $request->duration,
            'date' => $request->date,
            'time' => $request->time,
            'Note' => $request->Note,
        ]);


        if ($cats) {
            return response()->json(['errors' => 'false', 'message' => 'created successfully category', 'status' => 201], 200);
        }
    }
    public function edit($id)
    {
        $cat = Income::where('user_id', auth()->id())->where('id', $id)->first();
        if ($cat) {
            return response()->json([
                'errors' => 'false',
                'message' => 'get data successfully category',
                'data' => new IncomeResource($cat),
                'status' => 201
            ], 201);
        } else {
            return response()->json(['error' => true, 'message' => 'not there data', "status" => 404]);
        }
    }

    public function update(Request $request, $id)
    {

        $cat = Income::where('id',$id)->where('user_id',auth()->id())->first();
        if ($cat) {
            $validation = Validator::make($request->all(), [

                'type_name' => 'required',
                'type_expense' => 'required',
                'category_id' => 'required',
                'amount' => 'required',
                'bank_id' => 'required',
                'type_expense' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 200]);
            }
            $dataImage = $cat->image;

            $cat->update([
                'type_name' => $request->type_name,
                'type_expense' => $request->type_expense,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'bank_id' => $request->bank_id,
                'duration' => $request->duration,
                'date' => $request->date,
                'time' => $request->time,
                'Note' => $request->Note,
            ]);

            return response()->json([
                'errors' => 'false',
                'data' => new IncomeResource($cat),
                'status' => 201
            ]);
        }
        return response()->json(['errors' => true, 'message' => "somthing was error ", 'status' => 404],);
    }
    public function delete($id)
    {

        $cat = Income::find($id);
        if ($cat) {
            $cat->delete();
            return response()->json([
                'errors' => 'false',
                'message' => 'delete successfully bank',
                'status' => 200,
            ], 200);
        }
        return response()->json(['errors' => true, 'message' => "there is errors ", 'status' => 404]);
    }
}
