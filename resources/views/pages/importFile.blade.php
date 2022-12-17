@extends('layouts.default')
@section('content')
    <div class="container mt-5 text-center">
        <h2 class="mb-4">
            Import Export xls and xlsx File Only
        </h2>
        <form action="{{ route('file.import') }}" method="POST" enctype="multipart/form-data">
            @if (Session::has('success'))
            <div class="alert alert-success">
                    <strong>{{ Session::get('success') }}</strong>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger">
                <strong>{{ implode('', $errors->all(':message')) }}</strong>
            </div>
            @endif
            @csrf
            <div class="form-group mb-4">
                <div class="custom-file text-left">
                    <input type="file" name="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label mx-5" for="customFile">Choose file</label>
                </div>
            </div>
            <button class="btn btn-primary">Import File</button>
            <a class="btn btn-info" href="{{ route('file.index') }}">Go Back</a>
        </form>
    </div>
@stop
