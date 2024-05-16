<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dependent Dropdown Laravolt/Indonesia</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row mb-3">
            <label class="col-md-3 col-form-label" for="provinsi">Provinsi</label>
            <div class="col-md-9">
                <select class="form-control" name="provinsi" id="provinsi" required>
                    <option value="">== Pilih Provinsi ==</option>
                    @foreach ($provinces as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-md-3 col-form-label" for="kota">Kabupaten / Kota</label>
            <div class="col-md-9">
                <select class="form-control" name="kota" id="kota" required>
                    <option value="">== Pilih Kota ==</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-md-3 col-form-label" for="kecamatan">Kecamatan</label>
            <div class="col-md-9">
                <select class="form-control" name="kecamatan" id="kecamatan" required>
                    <option value="">== Pilih Kecamatan ==</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-md-3 col-form-label" for="desa">Desa</label>
            <div class="col-md-9">
                <select class="form-control" name="desa" id="desa" required>
                    <option value="">== Pilih Desa ==</option>
                </select>
            </div>
        </div>
    </div>

    <!-- jQuery and AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#provinsi').on('change', function(){
                var provinceId = $(this).val();
                if(provinceId){
                    $.ajax({
                        url: '{{ route("cities") }}',
                        type: 'GET',
                        data: { id: provinceId },
                        success: function(data){
                            $('#kota').empty();
                            $('#kota').append('<option value="">== Pilih Kota ==</option>');
                            $.each(data, function(key, value){
                                $('#kota').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('#kota').empty();
                    $('#kota').append('<option value="">== Pilih Kota ==</option>');
                }
            });

            $('#kota').on('change', function(){
                var cityId = $(this).val();
                if(cityId){
                    $.ajax({
                        url: '{{ route("districts") }}',
                        type: 'GET',
                        data: { id: cityId },
                        success: function(data){
                            $('#kecamatan').empty();
                            $('#kecamatan').append('<option value="">== Pilih Kecamatan ==</option>');
                            $.each(data, function(key, value){
                                $('#kecamatan').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option value="">== Pilih Kecamatan ==</option>');
                }
            });

            $('#kecamatan').on('change', function(){
                var districtId = $(this).val();
                if(districtId){
                    $.ajax({
                        url: '{{ route("villages") }}',
                        type: 'GET',
                        data: { id: districtId },
                        success: function(data){
                            $('#desa').empty();
                            $('#desa').append('<option value="">== Pilih Desa ==</option>');
                            $.each(data, function(key, value){
                                $('#desa').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('#desa').empty();
                    $('#desa').append('<option value="">== Pilih Desa ==</option>');
                }
            });
        });
    </script>
</body>
</html>
