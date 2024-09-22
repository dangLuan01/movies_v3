<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Checkout</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css'>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>


</head>
<style>
    body {
        background: #eee;
    }

    .card {
        box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, .125);
        border-radius: 1rem;
    }

    .card-body {
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.5rem 1.5rem;
    }

    .card-radio {
        background-color: #fff;
        border: 2px solid #eff0f2;
        border-radius: .75rem;
        padding: .5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block
    }

    .card-radio:hover {
        cursor: pointer
    }

    .card-radio-label {
        display: block
    }

    .card-radio-input {
        display: none
    }

    .card-radio-input:checked+.card-radio {
        border-color: #3b76e1 !important
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    i {
        padding-top: 10%;
    }

    h3 {
        font-size: 20px;
    }

    .text-navy {
        color: #1ab394;
    }

    a:hover {
        color: red;
    }
</style>

<body>

    <a style="position: absolute; right: 0; top: 0;margin-right: 4%;margin-top: 2%;}"
        href="{{ route('register-package') }}"><i class="fa-solid fa-circle-xmark fa-2x" aria-hidden="true"></i></a>
    @if (\Session::has('error'))
        <div class="alert alert-danger">{{ \Session::get('error') }}</div>
        {{ \Session::forget('error') }}
        {{ \Session::forget('total_paypal') }}
    @endif
    @if (\Session::has('success'))
        <div class="alert alert-success">{{ \Session::get('success') }}</div>
        {{ \Session::forget('success') }}
        {{ \Session::forget('total_paypal') }}
    @endif
    <div class="container">
        <h1 class="h3 mb-5">Thanh Toán</h1>
        <div class="row">
            <!-- Left -->
            <div class="col-lg-9">
                <div class="accordion" id="accordionPayment">
                    <div class="accordion-item mb-3">
                        <div class="card-body">
                            <ol class="activity-checkout mb-0 px-4 mt-3">
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-receipt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Thông tin khách hàng</h5>
                                            <p class="text-muted text-truncate mb-4">Tên và email được lấy theo tài
                                                khoản đã đăng nhập trước đó.
                                            </p>
                                            <div class="mb-3">
                                                <form>
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="billing-name">Tên
                                                                        <span style="color: red">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        id="billing-name"
                                                                        placeholder="{{ $user->name }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="billing-email-address">Đại chỉ Email <span
                                                                            style="color: red">*</span>
                                                                    </label>
                                                                    <input type="email" class="form-control"
                                                                        id="billing-email-address"
                                                                        placeholder="{{ $user->email }}" readonly>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="billing-phone">phone</label>
                                                                    <input type="text" class="form-control"
                                                                        id="billing-phone" placeholder="Enter Phone no."
                                                                        readonly>
                                                                </div>
                                                            </div> --}}
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-receipt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            @php
                                                $customer_id = Session::get('customer_id');
                                                $package_id = Session::get('package_id');
                                                $date = Session::get('package_time');
                                                $price = Session::get('package_price');
                                            @endphp
                                            <h5 class="font-size-16 mb-1">Thông tin gói phim</h5>
                                            {{-- <p class="text-muted text-truncate mb-4">Sed ut perspiciatis unde omnis iste
                                            </p> --}}
                                            <div class="mb-3">
                                                <div class="ibox-content">
                                                    <div class="table-responsive">
                                                        <table class="table shoping-cart-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="desc">
                                                                        <h3>
                                                                            <a href="#" class="text-navy">
                                                                                {{ $validate->title }}
                                                                            </a>
                                                                        </h3>
                                                                        <p class="small">
                                                                            <dt>Thông tin thời hạn:</dt>
                                                                            <dd>Thời hạn: {{ $date }} ngày</dd>
                                                                        </p>
                                                                        <dl class="small m-b-none">
                                                                            <dt>Mô tả:</dt>
                                                                            <dd>{!! $validate->description !!}</dd>
                                                                        </dl>

                                                                        {{-- <div class="m-t-sm">
                                                                            <a href="#" class="text-muted"><i
                                                                                    class="fa fa-gift"></i> Add gift
                                                                                package</a>
                                                                            |
                                                                            <a href="#" class="text-muted"><i
                                                                                    class="fa fa-trash"></i> Remove
                                                                                item</a>
                                                                        </div> --}}
                                                                    </td>
                                                                    <td>
                                                                        <h4>
                                                                            Giá:
                                                                            {{ number_format($price, 0, '', ',') }}.Vnđ
                                                                        </h4>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-wallet-alt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Thanh toán</h5>
                                            <p class="text-muted text-truncate mb-4">Chọn 1 trong 3 loại thanh toán bên
                                                dưới. </p>
                                        </div>
                                        <div>
                                            <h5 class="font-size-14 mb-3">Phương thức thanh toán :</h5>
                                            <div class="row">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div data-bs-toggle="collapse">
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="pay" value="vnpay"
                                                                id="pay-methodoption1" class="card-radio-input">
                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <i class="fa-solid fa-qrcode fa-2xl d-block mb-4"></i>
                                                                VnPay
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="pay" id="pay-methodoption2"
                                                                class="card-radio-input" value="paypal">
                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <i class="fa-brands fa-paypal fa-2xl d-block mb-4"></i>
                                                                Paypal
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="pay"
                                                                id="pay-methodoption3" class="card-radio-input"
                                                                value="momo">

                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <i
                                                                    class="fa-solid fa-money-bills fa-2xl d-block mb-4"></i>
                                                                <span>Momo</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Right -->
            <div class="col-lg-3">
                <div class="card position-sticky top-0">
                    <div class="p-3 bg-light bg-opacity-10">
                        <h6 class="card-title mb-3">Tóm tắt đơn hàng</h6>
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>Tạm tính</span> <span>{{ number_format($price, 0, '', ',') }}.Vnđ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>VAT</span> <span class="text-info">+10%</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4 small">
                            <span>Tổng cần thanh toán</span> <strong
                                class="text-dark">{{ number_format(($price * 10) / 100 + $price, 0, '', ',') }}.Vnđ</strong>
                        </div>
                        <form action="javascription:void(0);" onsubmit="return fun(this);">
                            <div class="form-check mb-1 small">
                                <input name="agree" class="form-check-input" type="checkbox"
                                    oninvalid="this.setCustomValidity('Vui lòng đồng ý chính sách của chúng tôi.')"
                                    oninput="this.setCustomValidity('')" required>
                                <label class="form-check-label" for="tnc">
                                    Tôi đồng ý với <a href="{{ route('policy') }}" target="_blank">các điều khoản và
                                        các
                                        điều kiện</a>
                                </label>
                            </div>

                            @php
                                $vnd_to_usd = (($price * 10) / 100 + $price) / 24270;
                                $total_paypal = round($vnd_to_usd, 2);
                                $total_vnpay = number_format(($price * 10) / 100 + $price, 0, '', '');
                                $total_momo = number_format(($price * 10) / 100 + $price, 0, '', '');

                                \Session::put('total_paypal', $total_paypal);
                                \Session::put('total_vnpay', $total_vnpay);
                                \Session::put('total_momo', $total_momo);
                            @endphp

                            <button type="submit" class="btn btn-primary w-100 mt-2">Thanh Toán
                                Ngay</button>

                        </form>
                        {{-- <a class="btn btn-primary m-3" href="{{ route('processTransaction') }}">Pay $100</a> --}}

                        <form id="paymentVnpay" action="{{ route('paymentVnpay') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>

                        <form id="paymentMomo" name="payUrl" action="{{ route('paymentMomo') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        function fun() {
            var pay = document.getElementsByName('pay');

            var payValue = false;
            for (i = 0; i < pay.length; i++) {
                if (pay[i].checked && pay[i].value == 'paypal') {
                    payValue = true;

                    Swal.fire({
                        title: "Bạn đồng ý chuyển đến trang thanh toán?",
                        text: "Rất vui khi bạn thanh toán!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace("{{ route('processTransaction') }}");
                        }
                    });

                }
                if (pay[i].checked && pay[i].value == 'momo') {
                    payValue = true;

                    Swal.fire({
                        title: "Bạn đồng ý chuyển đến trang thanh toán?",
                        text: "Rất vui khi bạn thanh toán!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#paymentMomo").submit();
                        }
                    });
                }
                if (pay[i].checked && pay[i].value == 'vnpay') {
                    payValue = true;
                    //alert('thanh toan vnpay');
                    Swal.fire({
                        title: "Bạn đồng ý chuyển đến trang thanh toán?",
                        text: "Rất vui khi bạn thanh toán!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#paymentVnpay").submit();
                        }
                    });
                    //     Swal.fire({
                    //     title: "Notify!",
                    //     text: "He thng thanh toan tren vnpay dang bao tri. Vui long quay lại sao. Hoac chon phuong thuc khac!",
                    //     icon: "error"
                    // });
                }

            }


            if (!payValue) {
                Swal.fire({
                    title: "Yêu cầu!",
                    text: "Vui lòng chọn phương thức thanh toán.",
                    icon: "error"
                });
                return false;
            }
        }
    </script>
</body>

</html>
