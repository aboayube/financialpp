<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adds;
use App\Http\Resources\AddsResource;
use App\Models\Adds as ModelsAdds;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class AddsController extends Controller
{

    public function index($lang)
    {
        $this->set_Language($lang);
        $adds = Adds::orderBy('id', 'DESC')->where('status', '1')->paginate(10);

        if ($adds->count() > 0) {
            return response()->json(['error' => false, 'data' => AddsResource::collection($adds), 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'message' => 'No adds found', 'status' => 200],);
        }
    }
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'name_en' => 'required',
            'body' => 'required',
            'body_en' => 'required',
            'status' => 'required',
            'image' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => true, 'message' => $validation->errors()], 200);
        }
        /*  if ($image = $request->file('image')) {
            $filename = Str::slug($request->post('image')) . '.' . $image->getClientOriginalExtension();
            $path = public_path('assets/banks/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $dataImage = $filename;
        } */

        $cats = auth()->user()->adds()->create([
            'name' => $request->post('name'),
            'name_en' => $request->post('name_en'),
            'image' => $request->image,
            'status' => $request->post('status'),
            'body' => $request->post('body'),
            'body_en' => $request->post('body_en'),
        ]);
        if ($cats) {
            return response()->json(['errors' => 'false', 'message' => 'created successfully adds', 'status' => 201], 200);
        }
    }
    public function edit($id)
    {
        $cat = Adds::find($id);
        if ($cat) {
            return response()->json([
                'errors' => 'false',
                'message' => 'get data successfully category',
                'data' => new AddsResource($cat),
                'status' => 201
            ], 201);
        } else {
            return response()->json(['error' => true, 'message' => 'not there data', "status" => 404]);
        }
    }

    public function update(Request $request, $id)
    {

        $cat = Adds::find($id);
        if ($cat) {
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'name_en' => 'required',
                'body' => 'required',
                'body_en' => 'required',
                'status' => 'required'
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 200]);
            }
            /*             $dataImage = $cat->image;
            if ($image = $request->file('image')) {
                $filename = Str::slug($request->post('image')) . '.' . $image->getClientOriginalExtension();
                $path = public_path('assets/adds/' . $filename);
                Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $dataImage = $filename;
            } */
            $cat->update([
                'name' => $request->name,
                'name_en' => $request->name_en,
                'body' => $request->body,
                'body_en' => $request->body_en,
                'status' => $request->status,
                'image' => $request->image,
            ]);

            return response()->json([
                'errors' => 'false',
                'data' => new AddsResource($cat),
                'status' => 201
            ]);
        }
        return response()->json(['errors' => true, 'message' => "somthing was error ", 'status' => 404],);
    }
    public function delete($id)
    {

        $cat = Adds::find($id);
        if ($cat) {
            $cat->delete();
            return response()->json([
                'errors' => 'false',
                'message' => 'delete successfully adds',
                'status' => 200,

            ], 200);
        }
        return response()->json(['errors' => true, 'message' => "there is errors ", 'status' => 404]);
    }
}
