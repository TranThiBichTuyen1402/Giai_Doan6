<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/home.css') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<section class="template-section py-5" id="featured_templates">

    <div class="container">

        <div class="text-center mb-5">

            <span class="badge rounded-pill px-3 py-2 mb-2 bg-danger-subtle text-danger">
                Mẫu giao diện
            </span>

            <h2 class="fw-bold">
                Một số mẫu thiệp nổi bật
            </h2>

            <p class="text-muted mx-auto" style="max-width:600px;">
                Bạn có thể phát triển thêm nhiều phong cách thiệp khác nhau nhưng vẫn giữ cùng một bố cục Bootstrap rõ ràng và dễ dùng.
            </p>

        </div>

        <div class="row g-4">

            <!-- Card 1 -->
             <div class="col-md-4">

            <div class="card template-card border-0 shadow-sm p-3">

                <div class="template-image">

                    <img src="{{ asset('images/mau-01.jpg') }}">

                </div>

                <div class="row mt-3 g-2">

                    <div class="col-6">

                        <a href="{{ route('templates.elegant') }}"
                           class="btn btn-outline-danger btn-template-preview w-100">

                            <i class="bi bi-eye"></i>

                            Xem chi tiết

                        </a>

                    </div>

                    <div class="col-6">

                        <a href="{{ route('create') }}"
                           class="btn btn-template-use w-100">

                            <i class="bi bi-stars"></i>

                            Dùng mẫu

                        </a>

                    </div>

                </div>

            </div>

        </div>

            <!-- Card 2 -->
            <div class="col-md-4">

            <div class="card template-card border-0 shadow-sm p-3">

                <div class="template-image">

                    <img src="{{ asset('images/mau-02.jpg') }}">

                </div>

                <div class="row mt-3 g-2">

                    <div class="col-6">

                        <a href="{{ route('templates.elegant') }}"
                           class="btn btn-outline-danger btn-template-preview w-100">

                            <i class="bi bi-eye"></i>

                            Xem chi tiết

                        </a>

                    </div>

                    <div class="col-6">

                        <a href="{{ route('create') }}"
                           class="btn btn-template-use w-100">

                            <i class="bi bi-stars"></i>

                            Dùng mẫu

                        </a>

                    </div>

                </div>

            </div>

        </div>


            <!-- Card 3 -->
            <div class="col-md-4">

            <div class="card template-card border-0 shadow-sm p-3">

                <div class="template-image">

                    <img src="{{ asset('images/mau-03.jpg') }}">

                </div>

                <div class="row mt-3 g-2">

                    <div class="col-6">

                        <a href="{{ route('templates.elegant') }}"
                           class="btn btn-outline-danger btn-template-preview w-100">

                            <i class="bi bi-eye"></i>

                            Xem chi tiết

                        </a>

                    </div>

                    <div class="col-6">

                        <a href="{{ route('create') }}"
                           class="btn btn-template-use w-100">

                            <i class="bi bi-stars"></i>

                            Dùng mẫu

                        </a>

                    </div>

                </div>

            </div>

        </div>

        </div>


        <div class="text-center mt-5">
            <div class="d-flex justify-content-center w-100 mt-5">
                <a href="{{ route('templates') }}"
                 class="btn rounded-pill fw-bold"
                    style="background-color: #d48888 !important; color: #ffffff !important; padding: 12px 35px !important; border: none !important; display: inline-block !important; text-decoration: none !important;">
                      Xem tất cả mẫu thiệp
                </a>    
            </div>

    </div>

</section>  