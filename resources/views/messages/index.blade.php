@extends('layouts.main')

@section('css')
@endsection

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">สินค้า</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item active">สินค้า</li>
            </ol>
            {{-- <div class="card mb-4">
            <div class="card-body">
                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                .
            </div>
        </div> --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    แสดงข้อความ
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-end mb-3">
                            <a href="{{ url('products/create') }}" class="btn btn-primary"><i
                                    class="fa-solid fa-plus"></i>เพิ่มรายการ</a>
                        </div>
                        <div class="col-12">
                            <table id="datatablesSimple" class="table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ลำดับ</th>
                                        <th>ข้อความ</th>
                                        <th>โดย</th>
                                        <th>โพสต์</th>
                                        <th>วันที่สร้าง</th>
                                        <th style="width: 15%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($fbMessages && count($fbMessages) > 0)
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($fbMessages as $item)
                                            <tr id="item-{{ $item->id }}">
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->content }}</td>
                                                <td>{{ $item->author_name }}</td>
                                                <td>{{ $item->post_subject }}</td>
                                                <td>{{ $item->created_time_show }}</td>
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
            // new DataTable('#datatablesSimple', {
            //     columnDefs: [{ width: '5%', targets: 0 }]
            // });
            $('.btn-destroy').on('click', function(e) {
                const id = $(this).attr('data-id');
                const url = "{{ route('api.v1.products.destroy') }}";
                const message = "คุณแน่ใจต้องการลบรายการนี้?";
                confirmDelNotify(id, url, message);
            });
        });
    </script>
@endsection
