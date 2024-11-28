@extends('layouts.main')

@section('css')
    <style>
        /* สไตล์ข้อความแจ้งเตือน */
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
@endsection

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">สินค้า</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/products') }}">สินค้า</a></li>
                <li class="breadcrumb-item active">แก้ไขสินค้า</li>
            </ol>
            <div class="card mb-4 col-8">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    แก้ไขสินค้า
                </div>
                <div class="card-body">
                    <form class="row g-3" id="frm-save" method="POST" action="{{ route('api.v1.products.update') }}">
                        <input type="hidden" name="edit_id" value="{{$product->id}}">
                        <div class="col-md-12">
                            <label for="name" class="form-label">ชื่อสินค้า <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" value="{{$product->name}}">
                        </div>
                        <div class="col-md-4">
                            <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" name="sku" class="form-control" id="sku" value="{{$product->sku}}">
                        </div>
                        <div class="col-md-4">
                            <label for="price" class="form-label">ราคาต่อหน่วย (บาท) <span class="text-danger">*</span></label>
                            <input type="text" name="price" class="form-control" id="price" value="{{$product->price}}">
                        </div>
                        <div class="col-md-4">
                            <label for="stock_quantity" class="form-label">จำนวน (อัพเดทสินค้าในสต๊อค) <span class="text-danger">*</span></label>
                            <input type="text" name="stock_quantity" class="form-control" id="stock_quantity" value="{{$product->stock_quantity}}">
                        </div>
                        <div class="col-md-12">
                            <label for="category_id" class="form-label">แคทตาล๊อต <span class="text-danger">*</span></label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="0">-เลือก-</option>
                                @if ($categories && count($categories) > 0)
                                    @foreach ($categories as $item)
                                    <option value="{{$item->id}}" @if($product->category_id == $item->id) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="category_description" class="form-label">รายละเอียด</label>
                            <textarea name="description" class="form-control" id="category_description" cols="30" rows="5">{{$product->description}}</textarea>
                        </div>
                        <div class="col-12 text-end">
                            <a href="{{ url('/products') }}" class="btn btn-danger" id="a-link-url"><i
                                    class="fa-solid fa-arrow-left"></i>
                                ยกเลิก</a>
                            <button type="submit" class="btn btn-primary btn-submit"><i
                                    class="fa-solid fa-floppy-disk"></i>
                                บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            const funcWebHook = (data) => {
                var alertType = 'error';
                var alertTitle = 'แจ้งเตือน';
                var alertMsg = data.message;
                var actionForm = $("input[name=action]").val();
                $(".btn-submit").attr("disabled", false);
                if (data.success) {
                    sweetNotify("success", data.message, "แจ้งเตือน", 2100);
                    setTimeout(() => {
                        window.location.href = $("#a-link-url").attr("href");
                    }, 2300);
                } else {
                    sweetNotify("error", data.message, "แจ้งเตือน", 2100);
                }
            }
            // ใช้ jQuery Validate
            $("#frm-save").validate({
                // กำหนดกฎการตรวจสอบ
                rules: {
                    name: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    sku: {
                        required: true,
                    },
                    price: {
                        required: true,
                    },
                    stock_quantity: {
                        required: true,
                    }
                },
                // ข้อความแสดงเมื่อเกิดข้อผิดพลาด
                messages: {
                    name: {
                        required: "กรุณากรอกชื่อสินค้า"
                    },
                    category_id: {
                        required: "กรุณาเลือกแคทตาล๊อต",
                    },
                    sku: {
                        required: "กรุณากรอก SKU",
                    },
                    price: {
                        required: "กรุณากรอกราคาต่อหน่วย (บาท)",
                    },
                    stock_quantity: {
                        required: "กรุณากรอกจำนวน (อัพเดทสินค้าในสต๊อค)",
                    }
                },
                // เพิ่มคลาส error ให้ input field และ label
                errorClass: "error", // คลาสที่ใช้สำหรับข้อความและ input ที่ผิดพลาด
                highlight: function(element) {
                    $(element).addClass("text-danger"); // เพิ่มคลาส error ให้ input ที่ไม่ผ่าน
                },
                unhighlight: function(element) {
                    $(element).removeClass("text-danger"); // ลบคลาส error เมื่อแก้ไขถูกต้อง
                },
                // กำหนดตำแหน่งของข้อความ error
                errorPlacement: function(error, element) {
                    error.insertAfter(element); // วางข้อความ error หลัง input field
                },
                // เมื่อ form ผ่านการ validate
                submitHandler: function(form) {
                    // form.submit();
                    $(".btn-submit").attr("disabled", "disabled");
                    ajaxSubmitForm("frm-save", "json", funcWebHook);
                    return false;
                }
            });
        });
    </script>
@endsection
