<?php

namespace App\Http\Controllers\Api\v1;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    function __construct()
    {
        ;
    }
    function getInfo(Request $request) {
        $response = ['success' => false, 'data' => [], 'message' => 'Error!'];
        $uid = $request->uid;

        $customer = Customer::find(intval($uid));
        if ($customer) {
            $response['success'] = true;
            $response['data'] = $customer;
        }
        return response()->json($response, 200);
    }
    function store(Request $request) {
        $response = ['success' => false, 'data' => [], 'message' => 'Error!'];

        if ($request->method('POST')) {
            $input = $request->all();

            $validator = Validator::make($input, [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'email' => 'required|string|email'
            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                return response()->json($response, 400);
            }
            
            $result = Customer::insert($input);
            if ($result) {
                $response['success'] = true;
                $response['data'] = $result;
                $response['message'] = 'บันทึกข้อมูลสำเร็จ!';
            }
        }

        return response()->json($response, 200);
    }
    function update(Request $request) {
        $response = ['success' => false, 'data' => [], 'message' => 'Error!'];

        if ($request->method('POST')) {
            $input = $request->all();
            $id = $input['edit_id'];
            
            $validator = Validator::make($input, [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'email' => 'required|string|email'
            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                
                return response()->json($response, 400);
            }
            
            unset($input['edit_id']);
            $data = [
                'first_name' => trim($input['first_name']),
                'last_name' => trim($input['last_name']),
                'phone' => trim($input['phone']),
                'address' => trim($input['address']),
                'email' => trim($input['email'])      //'required|string|email'
            ];
            $result = Customer::where('id', intval($id))->update($data);
            if ($result) {
                $response['success'] = true;
                $response['data'] = $result;
                $response['message'] = 'บันทึกข้อมูลสำเร็จ!';
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
            $result = Customer::where('id', intval($input['del_id']))->delete();
            if ($result) {
                $response = ['data' => [], 'success' => true, 'message' => 'ลบข้อมูลสำเร็จ'];
            }
        }

        return response()->json($response, 200);
    }
}
