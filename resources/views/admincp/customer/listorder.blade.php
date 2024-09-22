@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#Mã</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tên gói</th>
                            <th scope="col">Giá gói</th>
                            <th scope="col">Thời hạn của gói</th>
                            <th scope="col">Ngày bắt đầu</th>
                            <th scope="col">Ngày kết thúc</th>
                            <th scope="col">Thanh toán</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Ngày đăng ký</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_order as $order)
                        <tr>
                            
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->user->email }}</td>
                            <td>{{ $order->package->title }}</td>
                            <td>{{ number_format($order->price, 0, '', ',') }}</td>
                            <td>{{ $order->number_date }} Ngày</td>
                            <td> <span
                                    class="badge badge-soft-primary mb-1">{{ \Carbon\Carbon::createFromDate($order->date_start)->format('d-m-Y') }}</span>
                            </td>
                            <td><span
                                    class="badge badge-soft-warning mb-1">{{ \Carbon\Carbon::createFromDate($order->date_end)->format('d-m-Y') }}</span>
                            </td>
                            <td>{{ $order->payment }}</td>
                            <td>
                                @if ($order->expiry == 0)
                                    <span class="badge badge-soft-success mb-0">Đang sử dụng</span>
                                @else
                                    <span class="badge badge-soft-danger mb-0">Đã hết hạn sử dụng</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at }}</td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
