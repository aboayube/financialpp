<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Resources\CatoriesResource;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{

    public function index($lang)
    {
        $this->set_Language($lang);
        $banks = Bank::orderBy('id', 'DESC')->paginate(10);

        if ($banks->count() > 0) {
            return response()->json(['error' => false, 'data' => CatoriesResource::collection($banks), 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'message' => 'No bank found', 'status' => 200],);
        }
    }
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'name_en' => 'required',
            'image' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => true, 'message' => $validation->errors()], 200);
        }
        /*   if ($image = $request->file('image')) {
            $filename = Str::slug($request->post('image')) . '.' . $image->getClientOriginalExtension();
            $path = public_path('assets/banks/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $dataImage = $filename;
        } */

        $cats = auth()->user()->banks()->create([
            'name' => $request->post('name'),
            'name_en' => $request->post('name_en'),

            'image' => $request->post('image'), 'status' => $request->post('status')
        ]);
        if ($cats) {
            return response()->json(['errors' => 'false', 'message' => 'created successfully category', 'status' => 201], 200);
        }
    }
    public function edit($id)
    {
        $cat = Bank::find($id);
        if ($cat) {
            return response()->json([
                'errors' => 'false',
                'message' => 'get data successfully category',
                'data' => new CatoriesResource($cat),
                'status' => 201
            ], 201);
        } else {
            return response()->json(['error' => true, 'message' => 'not there data', "status" => 404]);
        }
    }

    public function update(Request $request, $id)
    {

        $cat = Bank::find($id);
        if ($cat) {
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'name_en' => 'required',
                'image' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 200]);
            }
            /*  $dataImage = $cat->image;
            if ($image = $request->file('image')) {
                $filename = Str::slug($request->post('image')) . '.' . $image->getClientOriginalExtension();
                $path = public_path('assets/banks/' . $filename);
                Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $dataImage = $filename;
            } */
            $cat->update([
                'name' => $request->name,
                'name_en' => $request->name_en,
                'image' => $request->image,
            ]);

            return response()->json([
                'errors' => 'false',
                'data' => new CatoriesResource($cat),
                'status' => 201
            ]);
        }
        return response()->json(['errors' => true, 'message' => "somthing was error ", 'status' => 404],);
    }
    public function delete($id)
    {

        $cat = Bank::find($id);
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
