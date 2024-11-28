<?php

namespace App\Http\Controllers\Api\v1;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    function __construct()
    {
        ;
    }
    function store(Request $request) {
        $response = ['data' => [], 'success' => false, 'message' => 'Error!'];

        if ($request->method('POST')) {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required'
            ]);
            if ($validator->fails()) {
                $response = ['data' => [], 'success' => false, 'message' => $validator->errors()->toJson()];
                return response()->json($response, 400);
            }
            // insert data
            $result = Category::create($input);
            if ($result) {
                $response = ['data' => $result, 'success' => true, 'message' => 'บันทึกข้อมูลสำเร็จ'];
            }
        }   
        return response()->json($response, 200);
    }
    function update(Request $request) {
        $response = ['data' => [], 'success' => false, 'message' => 'Error!'];

        if ($request->method('POST')) {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required'
            ]);
            if ($validator->fails()) {
                $response = ['data' => [], 'success' => false, 'message' => $validator->errors()->toJson()];
                return response()->json($response, 400);
            }
            // insert data
            $data = [
                'name' => $input['name'],
                'description' => $input['description']
            ];
            $result = Category::where('id', intval($input['edit_id']))->update($data);
            if ($result) {
                $response = ['data' => $result, 'success' => true, 'message' => 'บันทึกข้อมูลสำเร็จ'];
            }
        }   
        return response()->json($response, 200);
    }
    function destroy(Request $request) {
        $response = ['data' => [], 'success' => false, 'message' => 'Error!'];

        if ($request->method("POST")) {
            $input = $request->all();

            if (intval($input['del_id']) == 0) {
                $response = ['data' => [], 'success' => false, 'message' => 'ลบข้อมูลไม่สำเร็จ'];
                return response()->json($response, 400);
            }

            $result = Category::where('id', intval($input['del_id']))->delete();
            if ($result) {
                $response = ['data' => [], 'success' => true, 'message' => 'ลบข้อมูลสำเร็จ'];
            }
        }

        return response()->json($response, 200);
    }
}
