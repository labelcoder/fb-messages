@extends('layouts.main')

@section('css')
@endsection

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">รายการสั่งซื้อ</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">รายการสั่งซื้อ</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    แสดงรายการสั่งซื้อ
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-end mb-3">
                            <a href="{{ url('orders/create') }}" class="btn btn-primary"><i
                                    class="fa-solid fa-plus"></i>เพิ่มรายการ</a>
                            <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i>
                                ลบรายการ</button>
                        </div>
                        <div class="col-12">
                            <table id="datatablesSimple" class="table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ลำดับ</th>
                                        <th>รหัสสั่งซื้อ</th>
                                        <th>ลูกค้า</th>
                                        <th>วันที่สั่งซื้อ</th>
                                        <th>จำนวนสินค้า</th>
                                        <th>ราคาสินค้า (บาท)</th>
                                        <th>ส่วนลด (บาท)</th>
                                        <th>ราคาสินค้ารวม (บาท)</th>
                                        <th style="width: 15%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orders && count($orders) > 0)
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($orders as $item)
                                            <tr id="item-{{ $item->id }}">
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->code }}</td>
                                                <td>{{ $item->customer_name }}</td>
                                                <td>{{ $item->order_date }}</td>
                                                <td>{{ $item->total_qty }}</td>
                                                <td>{{ $item->price_amount }}</td>
                                                <td>{{ $item->discount_amount }}</td>
                                                <td>{{ $item->total_amount }}</td>
                                                <td>
                                                    {{-- <a href="{{ url('/products/update/' . $item->id) }}"
                                                        class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i>
                                                        แก้ไข</a> --}}
                                                    <button data-id="{{ $item->id }}" type="button"
                                                        class="btn btn-sm btn-danger btn-destroy"><i
                                                            class="fa-solid fa-trash"></i> ลบ</button>
                                                </td>
                                                @php
                                                    $i++;
                                                @endphp
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <script>
        $(document).ready(function() {
            $('.btn-destroy').on('click', function(e) {
                const id = $(this).attr('data-id');
                const url = "{{ route('api.v1.products.destroy') }}";
                const message = "คุณแน่ใจต้องการลบรายการนี้?";
                confirmDelNotify(id, url, message);
            });
        });
    </script>
@endsection
