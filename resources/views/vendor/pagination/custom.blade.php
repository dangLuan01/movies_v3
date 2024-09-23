@if ($paginator->hasPages())
    <div class="pagination2">
        <!-- Hiển thị thông tin tổng số trang -->
        <span>Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}:</span>
        
        <!-- Hiển thị trang đầu tiên chỉ khi trang hiện tại không phải là trang 1 -->
        @if ($paginator->currentPage() > 3)
            <a href="{{ $paginator->url(1) }}">1</a>
        @endif

        <!-- Hiển thị dấu '...' nếu trang hiện tại lớn hơn 4 -->
        @if ($paginator->currentPage() > 4)
            <a href="#">...</a>
        @endif
        
        <!-- Hiển thị các trang nằm gần trang hiện tại (trong khoảng -2 đến +2) -->
        @foreach (range(1, $paginator->lastPage()) as $i)
            @if ($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <a class="active" href="#">{{ $i }}</a>
                @else
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                @endif
            @endif
        @endforeach
        
        <!-- Hiển thị dấu '...' nếu trang hiện tại nhỏ hơn tổng số trang trừ đi 3 -->
        @if ($paginator->currentPage() < $paginator->lastPage() - 3)
            <a href="#">...</a>
        @endif
        
        <!-- Hiển thị trang cuối cùng nếu cần -->
        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
        @endif
        
        <!-- Hiển thị nút Next nếu có trang kế tiếp -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">
                <i class="ion-arrow-right-b"></i>
            </a>
        @else
            <a href="#" class="disabled"><i class="ion-arrow-right-b"></i></a>
        @endif
    </div>
@endif
