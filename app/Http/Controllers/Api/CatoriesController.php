<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Resources\CatoriesResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatoriesController extends Controller
{

    public function index($lang)
    {
        $this->set_Language($lang);
        $catoegiry = Category::orderBy('id', 'DESC')->paginate(10);

        if ($catoegiry->count() > 0) {
            return response()->json(['error' => false, 'data' => CatoriesResource::collection($catoegiry), 'status' => 200]);
        } else {
            return response()->json(['error' => true, 'message' => 'No categories found', 'status' => 200],);
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


        $cats = auth()->user()->categories()->create([
            'name' => $request->post('name'),
            'name_en' => $request->post('name_en'),
            'image' => $request->image,
            'status' => $request->post('status')
        ]);
        if ($cats) {

            return response()->json(['errors' => 'false', 'message' => 'created successfully category', 'status' => 201], 200);
        }
    }
    public function edit($id)
    {
        $cat = Category::find($id);
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

        $cat = Category::find($id);
        if ($cat) {
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'name_en' => 'required',
                'image' => 'required'
            ]);
            if ($validation->fails()) {
                return response()->json(['errors' => true, 'message' => $validation->errors(), 'status' => 200]);
            }
            /*  $dataImage = $cat->image;
            if ($image = $request->file('image')) {
                $filename = Str::slug($request->post('image')) . '.' . $image->getClientOriginalExtension();
                $path = public_path('assets/categories/' . $filename);
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

        $cat = Category::find($id);
        if ($cat) {
            $cat->delete();
            return response()->json([
                'errors' => 'false',
                'message' => 'delete successfully category',
                'status' => 200,

            ], 200);
        }
        return response()->json(['errors' => true, 'message' => "there is errors ", 'status' => 404]);
    }
}
