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
            <h1 class="mt-4">เพิ่มรายการสั่งซื้อ</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/orders') }}">รายการสั่งซื้อ</a></li>
                <li class="breadcrumb-item active">เพิ่มรายการสั่งซื้อ</li>
            </ol>
            <div class="card mb-4 col-8">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    เพิ่มรายการสั่งซื้อ
                </div>
                <div class="card-body">
                    <form class="row g-3" id="frm-save" method="POST" action="{{ route('api.v1.orders.store') }}">
                        <div class="col-md-12">
                            <label for="customer_id" class="form-label">ลูกค้า <span class="text-danger">*</span></label>
                            <select class="form-select" id="customer_id" name="customer_id">
                                <option selected value="0">-เลือก-</option>
                                @if ($customers && count($customers) > 0)
                                    @foreach ($customers as $item)
                                        <option value="{{ $item->id }}">{{ $item->fullname }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="name" class="form-label"><i class="fas fa-sort-amount-up-alt"></i> รายการสินค้า
                                <span class="text-danger">*</span></label>
                            <div>
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" width="12%"><i
                                                    class="fas fa-shopping-cart"></i> หยิบรายการ</th>
                                            <th scope="col">สินค้า</th>
                                            <th scope="col" width="20%">SKU</th>
                                            <th scope="col" class="text-center" width="18%">ราคาต่อหน่วย (บาท)</th>
                                            <th scope="col" class="text-center" width="10%">จำนวนสั่งซื้อ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($products && count($products) > 0)
                                            @foreach ($products as $item)
                                            <tr>
                                                <th scope="row" class="text-center">
                                                    <div class="form-check__ text-center">
                                                        <input class="form-check-input" name="item_ids[]" type="checkbox" value="{{$item->id}}"
                                                            id="flexCheckDefault">
                                                    </div>
                                                </th>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->sku}}</td>
                                                <td class="text-end">{{$item->price}}</td>
                                                <td class="text-end">
                                                    <input type="text" name="qty_numbers[{{$item->id}}]" class="form-control text-center" id="qty_{{$item->id}}" value="0">
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="address" class="form-label">ที่อยู่จัดส่ง <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" id="address" value="">
                        </div>

                        <div class="col-md-12">
                            <label for="note" class="form-label">หมายเหตุ</label>
                            <textarea name="note" class="form-control" id="note" cols="30" rows="3"></textarea>
                        </div>
                        <div class="col-12 text-end mt-5">
                            <a href="{{ url('/orders') }}" class="btn btn-danger" id="a-link-url"><i
                                    class="fa-solid fa-arrow-left"></i>
                                ยกเลิก</a>
                            <button type="submit" class="btn btn-primary btn-submit"><i class="fas fa-shopping-cart"></i>
                                สั่งซื้อ</button>
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
            $("#customer_id").change(function (e) { 
                e.preventDefault();
                const uid = $(this).val();
                $.get("{{route('api.v1.customers.get_info')}}", {uid:uid},
                    function (data) {
                        $("#address").val(data.data.address);
                    },
                    "json"
                );
                
            });
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
                    customer_id: {
                        required: true,
                    },
                    address: {
                        required: true,
                    }
                },
                // ข้อความแสดงเมื่อเกิดข้อผิดพลาด
                messages: {
                    customer_id: {
                        required: "กรุณาเลือกลูกค้า"
                    },
                    address: {
                        required: "กรุณากรอกที่อยู่จัดส่ง",
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
