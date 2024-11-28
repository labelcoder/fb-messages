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
            <h1 class="mt-4">แคทตาล๊อตสินค้า</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/categories') }}">แคทตาล๊อตสินค้า</a></li>
                <li class="breadcrumb-item active">เพิ่มแคทตาล๊อตสินค้า</li>
            </ol>
            <div class="card mb-4 col-6">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    เพิ่มแคทตาล๊อตสินค้า
                </div>
                <div class="card-body">
                    <form class="row g-3" id="frm-save" method="POST" action="{{ route('api.v1.categories.store') }}">
                        <div class="col-md-12">
                            <label for="category_name" class="form-label">ชื่อแคทตาล๊อต <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="category_name">
                        </div>
                        <div class="col-md-12">
                            <label for="category_description" class="form-label">รายละเอียด</label>
                            <textarea name="description" class="form-control" id="category_description" cols="30" rows="5"></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <a href="{{ url('/categories') }}" class="btn btn-danger" id="a-link-url"><i
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
                    }
                },
                // ข้อความแสดงเมื่อเกิดข้อผิดพลาด
                messages: {
                    username: {
                        required: "กรุณากรอกชื่อแคทตาล๊อต"
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
