@extends('layout')

@section('content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop Detail</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product') }}">Produk</a></li>
            <li class="breadcrumb-item active text-white">{{ $product->nama }}</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="{{ asset('storage/' . $product->gambar) }}" class="img-fluid rounded" alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <h4 class="fw-bold mb-3">{{ $product->nama }}</h4>
                            <p class="mb-3">Kategori: {{ $product->category ? $product->category->judul : 'Tidak ada kategori' }}</p>
                            <h5 class="fw-bold mb-3">Rp.{{ $product->harga }} / Kg</h5>
                            {!! $product->deskripsi_singkat !!}
                            <a href="#" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i
                                    class="fa fa-shopping-bag me-2 text-primary"></i> Beli Sekarang</a>
                        </div>
                        <div class="col-lg-12 mt-5">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                        role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">Deskripsi</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel"
                                    aria-labelledby="nav-about-tab">
                                    {!! $product->deskripsi_panjang !!}
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel"
                                    aria-labelledby="nav-mission-tab">
                                    <div class="d-flex">
                                        <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3"
                                            style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Jason Smith</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p>The generated Lorem Ipsum is therefore always free from repetition
                                                injected humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3"
                                            style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Sam Peters</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark">The generated Lorem Ipsum is therefore always free from
                                                repetition injected humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-vision" role="tabpanel">
                                    <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et
                                        tempor sit. Aliqu diam
                                        amet diam et eos labore. 3</p>
                                    <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos
                                        labore.
                                        Clita erat ipsum et lorem et sit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">Produk Lainnya</h1>
            <br>
            <div class="row">
                @foreach ($similar_products->take(4) as $similar_product)
                    <div class="col-6 col-md-6 mb-4">
                        <div class="border border-primary rounded position-relative vesitable-item h-100">
                            <div class="vesitable-img text-center py-2">
                                <img src="{{ asset('storage/' . $similar_product->gambar) }} " 
                                     class="img-fluid rounded-top"
                                     style="width: 450px; height: 250px; object-fit: cover;" alt="">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                style="top: 10px; right: 10px; font-size: 0.8rem;">
                                {{ $similar_product->category->judul }}
                            </div>
                            <div class="p-2 pb-0 rounded-bottom">
                                <h6 style="font-weight: bold;">{{ $similar_product->nama }}</h6>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-6 fw-bold mb-0">Rp{{ number_format($similar_product->harga, 0, ',', '.')  }} / kg</p>
                                    <a href="{{ route('product.show', $similar_product->slug) }}"
                                        class="btn border border-secondary rounded-pill px-2 py-1 mb-2 text-primary" style="font-size: 0.8rem;">
                                        <i class="fa fa-eye me-2 text-primary"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Single Product End -->

@endsection