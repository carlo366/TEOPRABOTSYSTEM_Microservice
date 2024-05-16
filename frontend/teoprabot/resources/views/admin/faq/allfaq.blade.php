@extends('admin.layouts.template')
@section('title','Admin | All dfaq')
@push('css')
<link rel="stylesheet" href="{{asset('admin/vendors/choices.js/choices.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/vendors/quill/quill.bubble.css')}}">
<link rel="stylesheet" href="{{asset('admin/vendors/quill/quill.snow.css')}}">
<link rel="stylesheet" href="{{asset('admin/vendors/simple-datatables/style.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush
@section('main-content')


<!--Form Add dfaq  -->
<div class="modal fade text-left" id="tambahdfaq" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel33" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header">

            <h4 class="modal-title" id="myModalLabel33">Tambah dfaq</h4>

                    </div>
                    <form action="{{ route('storefaq') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label>Nama dfaq</label>
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Nama dfaq" class="form-control" required oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" autofocus>
                            </div>
                            <label>Description</label>
                            <div class="form-group mb-3">
                                <textarea id="summernote" name="description"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Batal</span>
                            </button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>

                </div>
                </div>
            </div>

<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>dfaq</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">dfaq</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="pb-3 pt-4"><button type="button" class="btn btn-success p-3"  data-bs-toggle="modal" data-bs-target="#tambahdfaq"> Tambah dfaq</button></div>
    </div>
    <section class="section">
        <div class="card">

            <div class="card-body">
                @if (session()->has('message'))
                <div id="alertMessage" class="alert alert-success">
                    {{ session()->get('message') }}
                </div>

                @endif

                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama dfaq</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach ($data  as $key => $category)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{$category['name']}}</td>
                            <td>{{$category['description']}}</td>
                            <td>
                                <a href="{{route('editfaq', $category['ID'])}}" class="btn btn-warning">Edit</a>
                                <a href="#" onclick="confirmDelete('{{ $category['ID'] }}')" data-name="" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
        </div>
    </div>
@endsection
@push('js')
<script src="{{asset('admin/vendors/simple-datatables/simple-datatables.js')}}"></script>
<script src="{{asset('admin/js/vendors.js')}}"></script>
<script src="{{asset('admin/vendors/choices.js/choices.min.js')}}"></script>
<script src="{{asset('admin/vendors/quill/quill.min.js')}}"></script>
<script src="{{asset('admin/js/pages/form-editor.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
function confirmDelete(productId) {
        swal({
            title: "Yakin ingin menghapus?",
            text: "Data akan hilang jika dihapus!",
            icon: "warning",
            buttons: {
                cancel: "Batal",
                confirm: {
                    text: "Hapus",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                }
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // Jika pengguna menekan "Hapus", arahkan ke route delete dengan menyertakan ID
                window.location.href = "{{ route('deletefaq', ':id') }}".replace(':id', productId);
                swal("Poof! Your imaginary file has been deleted!", {
    icon: "success",
    timer: 1500,
button:false,});
            } else {
                swal("Operasi dibatalkan.", {
                    icon: "info",
                    buttons: false,
                    timer: 1500,
                });
            }
        });
    }
    function berhasil() {
        swal({
            title: "Berhasil",
            text: "menambahkan kategori",
            icon: "success",
            dangerMode: true,
            button: false,
            time: 1500,
        })
    }
    </script>
       {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
      <!-- jQuery (required for Summernote) -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Summernote JS -->
      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

      <script>
$(document).ready(function() {
$('#summernote').summernote({
placeholder: 'Isi Deskripsi',
tabsize: 2,
height: 300,
callbacks: {
  onInit: function() {
    // Menghapus tag <p></p> dari konten awal saat editor diinisialisasi
    var content = $(this).summernote('code');
    // Menghapus tag <p></p> dari awal konten jika ada
    if (content.startsWith('<p>') && content.endsWith('</p>')) {
      content = content.substring(3, content.length - 4);
    }
    $(this).summernote('code', content);
  }
}
});
});


      </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


@endpush
