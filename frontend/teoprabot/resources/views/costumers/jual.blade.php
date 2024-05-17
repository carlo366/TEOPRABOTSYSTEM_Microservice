@extends('costumers.layouts.template')
@section('main-content')

<div class="container mt-5">
    <h2>Input Data</h2>
    <form id="inputForm" action="{{ route('tambahjual') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description" required></textarea>
        </div>
        <div class="form-group">
            <label for="saranprice">Suggested Price:</label>
            <input type="number" class="form-control" id="saranprice" name="saran_price" placeholder="Enter suggested price" required>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image">
        </div>
        <div class="form-group">
            <label for="kondisi_id">Condition ID:</label>
            <select class="form-control" id="kondisi_id" name="kondisi_id">
                @foreach ($data as $categori)
                    <option value="{{ $categori['ID'] }}">{{ $categori['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="category_id">Category ID:</label>
            <select class="form-control" id="category_id" name="category_id">
                @foreach ($categories as $categori)
                    <option value="{{ $categori['ID'] }}">{{ $categori['name'] }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
  <!-- Gallery -->
@endsection
