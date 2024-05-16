@extends('admin.layouts.template')
@section('title','Admin | All Kategori')
@push('css')
<link rel="stylesheet" href="{{asset('admin/vendors/simple-datatables/style.css')}}">
@endpush
@section('main-content')


            <!--Table Categori -->

<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Kategori</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminallkategori')}}">Kategori</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Kategori</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">

            <form action="{{ route('updatecategory', ['id' => $data['ID']]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="col-sm-4">
                        <h6>Nama Kategori</h6>
                        <input class="form-control form-control-lg" type="text" value="{{ $data['name'] }}" name="name" placeholder="Nama Kategori">
                    </div>
                    <div class="col-sm-4">
                        <h6>Gambar Kategori</h6>
                        <img src="{{ asset('uploads/slider/' . $data['image']) }}" style="width: 4em" alt="Gambar Kategori">
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <input type="hidden" name="old_image" value="{{ $data['image'] }}">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('adminallkategori') }}" class="btn btn-light-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

    </section>
</div>


        </div>
    </div>
@endsection
@push('js')
<script src="{{asset('admin/vendors/simple-datatables/simple-datatables.js')}}"></script>
<script src="{{asset('admin/js/vendors.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush
