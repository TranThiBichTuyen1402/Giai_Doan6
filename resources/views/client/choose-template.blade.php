@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold">Chọn Mẫu Thiệp Cưới</h2>
        <p class="text-muted">
            Hãy chọn mẫu bạn yêu thích để bắt đầu thiết kế
        </p>
    </div>

    <div class="row g-4">
        @if(isset($templates) && count($templates) > 0)
           <div class="row g-4">
    @foreach($templates as $template)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="template-preview">
                   <iframe
    src="{{ route('card.demo', ['id' => $template->id]) }}"
    class="w-100 border-0"
    style="height: 500px; pointer-events: none;"
    loading="lazy">
</iframe>
                </div>

                <div class="card-body text-center p-4">
                    <h5 class="fw-bold">{{ $template->name }}</h5>
                    <p class="text-muted small">{{ $template->description }}</p>

                    <a href="{{ route('card.builder', ['template_id' => $template->id]) }}"
                       class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-check-circle me-1"></i> Chọn mẫu này
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
        @else
            <div class="col-12 text-center py-5">
                <p class="text-muted">Chưa có mẫu thiệp nào trong cơ sở dữ liệu.</p>
            </div>
        @endif
    </div>

</div>

@endsection