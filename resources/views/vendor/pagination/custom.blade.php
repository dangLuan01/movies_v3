{{-- @if ($paginator->hasPages())

    <nav aria-label="Page navigation example">

        <ul class="pagination justify-content-end">

            @if ($paginator->onFirstPage())
                <li class="page-item disabled">

                    <a class="page-link" href="#" tabindex="-1">Previous</a>

                </li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">

                                <a class="page-link">{{ $page }}</a>

                            </li>
                        @else
                            <li class="page-item">

                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>

                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach



            @if ($paginator->hasMorePages())
                <li class="page-item">

                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>

                </li>
            @else
                <li class="page-item disabled">

                    <a class="page-link" href="#">Next</a>

                </li>
            @endif

        </ul>

@endif --}}
@if ($paginator->hasPages())
    <style>
        /* CSS cho phân trang */
        .pagination {
            list-style: none;
            padding: 3%;
            margin: 20px 0;
            /* điều chỉnh khoảng cách giữa phân trang và nội dung */
            text-align: center;
            /* căn giữa các phần tử trong phân trang */
        }

        .pagination li {
            display: inline-block;
            /* hiển thị các mục trong dòng */
            margin-right: 5px;
            /* khoảng cách giữa các mục */
        }

        .pagination li a,
        .pagination li span {
            padding: 24px 30px;
            text-decoration: none;
            border: 1px solid #ccc;
            color: #333;
            border-radius: 35px;
            font-size: 16px;
        }

        .pagination li.active span {
            background-color: #007bff;
            color: #fff;
            padding: 27px 35px;
            font-size: 27px;
            border-radius: 44px;
        }

        .pagination li.disabled span,
        .pagination li.disabled a {
            color: #aaa;
            /* màu chữ cho nút vô hiệu */
            cursor: not-allowed;
            /* con trỏ không cho nút vô hiệu */
        }

        .pagination li.hidden-xs {
            display: none;
            /* ẩn các mục trên màn hình nhỏ */
        }

        /* Điều chỉnh cho thiết bị di động */
        @media only screen and (max-width: 768px) {

            .pagination li a,
            .pagination li span {
                padding: 9px 14px;
                font-size: 15px;
            }

            .pagination li.active span {
                padding: 9px 17px;
                font-size: 25px;
                border-radius: 26px;
            }
            .pagination li{
                margin-top: 5%;
            }
        }
    </style>
    <ul class="pagination pagination">
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>Previous</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a></li>
        @endif
        @if ($paginator->currentPage() > 3)
            <li class="hidden-xs"><a href="{{ $paginator->url(1) }}">1</a></li>
        @endif
        @if ($paginator->currentPage() > 4)
            <li><span>...</span></li>
        @endif
        @foreach (range(1, $paginator->lastPage()) as $i)
            @if ($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if ($paginator->currentPage() < $paginator->lastPage() - 3)
            <li><span>...</span></li>
        @endif
        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="hidden-xs"><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            </li>
        @endif
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
        @else
            <li class="disabled"><span>Next</span></li>
        @endif
    </ul>
@endif
