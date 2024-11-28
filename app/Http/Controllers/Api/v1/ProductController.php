<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    function __construct()
    {
        ;
    }
    function store(Request $request) {
        $response = ['data' => [], 'success' => false, 'message' => 'Error!'];

        if ($request->method("POST")) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name' => 'required',
                'sku' => 'required',
                'category_id' => 'required',
                'price' => 'required',
                'stock_quantity' => 'required'
            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                return response()->json($response, 400);
            }
            $input['category_id'] = intval($input['category_id']);
            $result = Product::insert($input);
            if ($result) {
                $response['data'] = $result;
                $response['success'] = true;
                $response['message'] = 'บันทึกข้อมูลสำเร็จ';
            }
        }

        return response()->json($response, 200);
    }
    function update(Request $request) {
        $response = ['success' => false , 'data' => [], 'message' => 'Error!'];

        if ($request->method('POST')) {
            $input = $request->all();
            $editId = intval($input['edit_id']);
            $validator = Validator::make($input, [
                'name' => 'required',
                'sku' => 'required',
                'category_id' => 'required',
                'price' => 'required',
                'stock_quantity' => 'required'
            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                return response()->json($response, 400);
            }
            $input['category_id'] = intval($input['category_id']);

            $data = [
                'name' => $input['name'],
                'sku' => $input['sku'],
                'category_id' => intval($input['category_id']),
                'price' => $input['price'],
                'description' => $input['description'],
                'stock_quantity' => $input['stock_quantity']
            ];
            // unset($input['edit_id']);
            $result = Product::where('id', intval($input['edit_id']))->update($data);
            if ($result) {
                $response['data'] = $result;
                $response['success'] = true;
                $response['message'] = 'บันทึกข้อมูลสำเร็จ';
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
            $result = Product::where('id', intval($input['del_id']))->delete();
            if ($result) {
                $response = ['data' => [], 'success' => true, 'message' => 'ลบข้อมูลสำเร็จ'];
            }
        }
        return response()->json($response, 200);
    }
}
