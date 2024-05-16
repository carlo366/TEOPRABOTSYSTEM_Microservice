@extends('costumers.layouts.template')
@section('main-content')

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css?family=Muli&display=swap');

* {
  box-sizing: border-box;
}

body {
  font-family: 'Muli', sans-serif;
  background-color: #f0f0f0;
}

h1 {
  margin: 50px 0 30px;
  text-align: center;
}

.faq-container {
  max-width: 600px;
  margin: 0 auto;
}

.faq {
  background-color: transparent;
  border: 1px solid #9fa4a8;
  border-radius: 10px;
  margin: 20px 0;
  padding: 30px;
  position: relative;
  overflow: hidden;
  transition: 0.3s ease;
}

.faq.active {
  background-color: #fff;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
}

.faq.active::before,
.faq.active::after {
  content: '\f075';
  font-family: 'Font Awesome 5 Free';
  color: #2ecc71;
  font-size: 7rem;
  position: absolute;
  opacity: 0.2;
  top: 20px;
  left: 20px;
  z-index: 0;
}

.faq.active::before {
  color: #3498db;
  top: -10px;
  left: -30px;
  transform: rotateY(180deg);
}

.faq-title {
  margin: 0 35px 0 0;
}

.faq-text {
  display: none;
  margin: 30px 0 0;
}

.faq.active .faq-text {
  display: block;
}

.faq-toggle {
  background-color: transparent;
  border: 0;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  padding: 0;
  position: absolute;
  top: 30px;
  right: 30px;
  height: 30px;
  width: 30px;
}

.faq-toggle:focus {
  outline: 0;
}

.faq-toggle .fa-times {
  display: none;
}

.faq.active .faq-toggle .fa-times {
  color: #fff;
  display: block;
}

.faq.active .faq-toggle .fa-chevron-down {
  display: none;
}

.faq.active .faq-toggle {
  background-color: #9fa4a8;
}

</style>
@endsection
    <div class="sliderr">
<div class="container">
    <div class="text-center">
        <div class="row">
          <div class="col-md-8 pt-3 ps-0 pe-0">



              <div class="banner">

                  <div class="container">

                      <div class="slider-container has-scrollbar">

                        @foreach ($slider as $slid)


                        <div class="slider-item">

                            <img src="{{asset('uploads/slider/'.$slid['image'])}}" alt="{{$slid['name']}}" class="banner-img">

                            <div class="banner-content">

                            </div>

                        </div>
                        @endforeach

              </div>

            </div>

          </div>

        </div>

        <div class="col-md-4 ">
            <div class="row gambarr">
                <div class="col-md-12 pt-3 pb-3 ps-0">
                    <div class="banner__pic">
                        <img src="{{asset('costumer/img/catsemprot.png')}}" class="img_slider" alt="">
                    </div>
                </div>
                <div class="col-md-12 ps-0">
                    <div class="banner__pic">
                        <img src="img/banner/banner-1.jpg" class="img_slider"  alt="">
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
</div>
<div class="top-category-box">
    <div class="container">
        <div class="category-box">
            <div class="category-container">
                <div class="category">Lemari</div>

                <div class="category">
                    <div class="icon-text-container">
                        <i class="fas fa-chair"></i>
                        <p class="category-text">Lemari Gantung</p>
                    </div>
                </div>

                <div class="category">
                    <div class="icon-text-container">
                        <i class="fas fa-chair"></i>
                        <p class="category-text">Kursi</p>
                    </div>
                </div>

                <div class="category">
                    <div class="icon-text-container">
                        <i class="fas fa-table"></i>
                        <p class="category-text">Meja</p>
                    </div>
                </div>
                <div class="category">
                    <div class="icon-text-container">
                        <i class="fas fa-bed"></i>
                        <p class="category-text">Kasur</p>
                    </div>
                </div>
                <div class="category">
                    <div class="icon-text-container">
                        <i class="fas fa-couch"></i>
                        <p class="category-text">Sofa</p>
                    </div>
                </div>
                <div class="category">
                    <div class="icon-text-container">
                        <i class="fas fa-bookshelf"></i>
                        <p class="category-text">Rak Buku</p>
                    </div>
                </div>
                <!-- Tambahkan kategori lainnya sesuai kebutuhan -->
            </div>
        </div>
        <hr>
    </div>
</div>


    </div>
    <!-- <div style="width: 100%;height:3em;background-color:#AF8260"></div> -->
<br><br><br>

      <div class="container produkk" >
        <div class="row justify-content-center" >
            <div class=" text-center" >
                <div class="section-title container-fluid"    >
                    <h1>Produk Terbaru</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore
                        magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="row">


            @foreach($products as $product)
            <!-- single product -->

            <div class="col-lg-3 col-md-6" style="">
                <a href="{{route('produkdetail',$product['ID'])}}">
                    <div class="single-product">
                        @if ($product['image'])
                        <img class="img-fluid" src="{{asset('uploads/product/'.$product['image'])}}" alt="">
                        @else
                        <p>No image available</p>
                        @endif

                        <div class="product-details">
                        <h6>{{$product['name']}}</h6>
                        <div class="price">
                            <h6>{{$product['price']}}</h6>
                            @foreach ($data as $d )

                            @if ($d['ID'] == $product['category_id'])
                            <h6 >{{$d['name'] }}</h6>
                            @endif
                            @endforeach
                        </div>
                        <div class="prd-bottom">
                            {{-- <a href="" class="social-info">
                                <span class="ti-bag"></span>
                                <p class="hover-text">add to bag</p>
                            </a> --}}
                            {{-- <a href="" class="social-info">
                                <span class="lnr lnr-heart"></span>
                                <p class="hover-text">Wishlist</p>
                            </a>
                            <a href="" cla
                            ss="social-info">
                                <span class="lnr lnr-sync"></span>
                                <p class="hover-text">compare</p>
                            </a> --}}
                            {{-- <a href="{{route('produkdetail', $product->id_products)}}" class="social-info">
                                <span class="lnr lnr-move"></span>
                                <p class="hover-text">view more</p>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </a>
            </div>


            @endforeach



        </div>
    </div>
</div>


    <!-- Feature Start -->
    <div class="container-fluid overflow-hidden py-5 px-lg-0">
        <div class="container feature py-5 px-lg-0" style="	background-color:#402218;
        ">
            <div class="row g-5 mx-lg-0">
                <div class="col-lg-6 feature-text wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase mb-3">Fitur Kami</h6>
                    <div class="d-flex mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <i class="fa fa-headphones text-light fa-3x flex-shrink-0 text-light"></i>
                        <div class="ms-4">
                            <h5>Layanan Pelanggan 24/7</h5>
                            <p class="mb-0 text-light">Jangan Ragu untuk Hubungi Kami! Tim Layanan Pelanggan Kami
                                Siap Membantu Anda Setiap Saat</p>
                        </div>
                    </div>
                    <div class="d-flex mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <i class="fa fa-globe text-light fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Jangan Ragu untuk Hubungi Kami! Tim Layanan Pelanggan Kami
                                Siap Membantu Anda Setiap Saat</h5>
                            <p class="mb-0 text-light">Kami punya banyak pilihan perabotan baru dan bekas yang bisa
                                kamu jelajahi. Dengan begitu, kamu bisa menemukan sesuatu yang cocok dengan selera dan anggaranmu</p>
                        </div>
                    </div>
                    <div class="d-flex mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <i class="fa fa-globe text-light fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Opsi Tukar Tambah</h5>
                            <p class="mb-0 text-light">Tingkatkan koleksi perabotan Anda dengan mudah melalui program tukar tambah kami. Dapatkan nilai tukar yang bisa langsung digunakan untuk membeli perabotan baru, memudahkan Anda untuk menghadirkan suasana segar dalam dekorasi rumah Anda</p>
                        </div>
                    </div>
                    <div class="d-flex mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <i class="fa fa-globe text-light fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Solusi Pengiriman yang Fleksibel dan Terpercaya</h5>
                            <p class="mb-0 text-light">Kami siap menyediakan pengiriman yang sesuai dengan kebutuhan Anda, termasuk waktu dan jenis barang yang Anda kirimkan. Anda dapat mempercayai kami untuk pengiriman yang aman dan tepat waktu.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-5 wow fadeInUp" data-wow-delay="0.3s">
                        <i class="fa fa-globe text-light fa-3x flex-shrink-0"></i>
                        <div class="ms-4">
                            <h5>Solusi Pengiriman yang Fleksibel dan Terpercaya</h5>
                            <p class="mb-0 text-light">Layanan kami menawarkan perbaikan yang handal untuk barang-barang yang rusak. Dari perbaikan kecil hingga pemulihan total, kami siap membantu menjaga barang Anda tetap dalam kondisi terbaik."</p>
                        </div>
                    </div>


                </div>
                <div class="col-lg-6 pe-lg-0 wow fadeInRight" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100" src="{{asset('costumer/img/pengirim.jpg')}}" style="object-fit: cover;" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->
    <h1 class="mb-0">FaQ</h1>



    <div class="faq-container">
        @foreach ($datafaq as $faq )

        <div class="faq">
            <h3 class="faq-title">
                {{$faq['name']}}
            </h3>

            <p class="faq-text">
              {{$faq['description']}}
            </p>

            <button class="faq-toggle">
                <i class="fas fa-chevron-down"></i>
                <i class="fas fa-times"></i>
            </button>
        </div>

        @endforeach

    </div>



    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="text-center">
                <h6 class="text-secondary text-uppercase">Riview </h6>
                <h1 class="mb-0">Customer Kami</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="{{asset('costumer/img/testimonial-1.jpg')}}" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="{{asset('costumer/img/testimonial-2.jpg')}}" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="{{asset('costumer/img/testimonial-3.jpg')}}" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="{{asset('costumer/img/testimonial-4.jpg')}}" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="{{asset('img/testimonial-4.jpg')}}" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="{{asset('img/testimonial-4.jpg')}}" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
                <div class="testimonial-item p-4 my-5">
                    <i class="fa fa-quote-right fa-3x text-light position-absolute top-0 end-0 mt-n3 me-4"></i>
                    <div class="d-flex align-items-end mb-4">
                        <img class="img-fluid flex-shrink-0" src="{{asset('img/testimonial-4.jpg')}}" style="width: 80px; height: 80px;">
                        <div class="ms-4">
                            <h5 class="mb-1">Client Name</h5>
                            <p class="m-0">Profession</p>
                        </div>
                    </div>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

@endsection
@section('js')
<script>const buttons = document.querySelectorAll('.faq-toggle');

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            button.parentNode.classList.toggle('active');
        });
    });</script>

@endsection
