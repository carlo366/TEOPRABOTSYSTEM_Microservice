@extends('admin.layouts.template')
@section('title','Admin | All Produk')
@push('css')
<link rel="stylesheet" href="{{asset('admin/vendors/simple-datatables/style.css')}}">
<link rel="stylesheet" href="{{asset('admin/vendors/choices.js/choices.min.css')}}">
<link rel="stylesheet" href="{{asset('admin/vendors/quill/quill.bubble.css')}}">
<link rel="stylesheet" href="{{asset('admin/vendors/quill/quill.snow.css')}}">
<link rel="stylesheet" href="{{asset('admin/vendors/simple-datatables/style.css')}}">
@endpush
@section('main-content')
            <!--Table Produk -->
            <form action="{{ route('updateProduk', ['id' => $data['ID']]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="overflow-y: auto; max-height: 80vh;">
                    <div class="col">
                        <h6>Nama Produk</h6>
                        <input class="form-control form-control-lg" id="name" name="name"  value="{{$data['name']}}"  type="text" placeholder="Nama Produk">
                    </div>
                    <br>
                    <div class="basic-choices">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6>Kategori</h6>
                                <div class="form-group">
                                    <select class="form-control" id="category_id" name="category_id">
                                        @foreach ($categories as $categori)
                                            <option value="{{ $categori['ID'] }}">{{ $categori['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="section">
                        <h6>Deskripsi Produk</h6>
                        <div class="form-group mb-3">
                            <textarea id="summernote" name="description">{{$data['description']}}</textarea>
                        </div>
                    </section>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="length">Panjang:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="{{$data['length']}}" id="length" name="length" min="0" placeholder="Panjang">
                                    <div class="input-group-append">
                                        <span class="input-group-text">CM</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="width">Lebar:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="{{$data['width']}}" id="width" name="width" min="0" placeholder="Lebar">
                                    <div class="input-group-append">
                                        <span class="input-group-text">CM</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="color">Warna:</label>
                                <input type="text" class="form-control" id="color" value="{{$data['Color']}}" name="color" placeholder="Misal: Putih, Merah, dll">
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label for="price">Harga:</label>
                    <input type="number" class="form-control" value="{{$data['price']}}" id="price" name="price" min="0" placeholder="Masukkan harga">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Jumlah:</label>
                        <input type="number" value="{{$data['quantity']}}" class="form-control" id="quantity" name="quantity" min="0" placeholder="Masukkan jumlah">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{route('adminallproduk')}}" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>



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
function confirmDelete(categoryId) {
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
                window.location.href = "{{ route('deletecategori', ':id') }}".replace(':id', categoryId);
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
