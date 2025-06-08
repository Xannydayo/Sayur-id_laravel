@extends('layout')

@section('content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white">Produk</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">Fresh fruits shop</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-lg-3 mb-4 mb-lg-0" style="border-right: 1.5px solid #e0e0e0;">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Kategori</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            @foreach ($categories as $category)
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="{{ route('product.category',$category->slug) }}">{{ $category->judul }}</a>
                                                    <span>({{ $category->products->count() }})</span>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="{{ Storage::url($promotion->gambar) }}" class="img-fluid w-100 rounded" alt="">
                                        <div class="position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%);">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 ps-lg-5">
                            <div class="row g-4 justify-content-center">
                                <div class="container">
                                    <h2 class="fw-bold mb-4">Fresh fruits shop</h2>
                                    <div class="row">
                                        @foreach ($products as $product)
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
                                                <div class="card shadow-sm border-0 w-100 h-100">
                                                    <div class="position-relative">
                                                        <img src="{{ Storage::url($product->gambar) }}" class="card-img-top" style="height: 180px; object-fit: cover; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                                                        <span class="badge bg-warning text-dark position-absolute" style="top: 10px; left: 10px;">{{ $product->category->judul }}</span>
                                                    </div>
                                                    <div class="card-body d-flex flex-column">
                                                        <h5 class="card-title text-center mb-2" style="font-weight: bold;">{{ $product->nama }}</h5>
                                                        <p class="card-text text-center mb-2" style="font-size: 1.1rem;">{{ number_format($product->harga, 0, ',', '.') }} / kg</p>
                                                        <div class="mt-auto text-center">
                                                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-success rounded-pill px-4 py-1">
                                                                <i class="fa fa-eye me-2"></i> Detail
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->

@endsection