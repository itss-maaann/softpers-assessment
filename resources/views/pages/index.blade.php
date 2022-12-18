@extends('layouts.default')
@section('content')
    <div class="container mt-5 text-center">
        <div class="p-6 bg-white border-b border-gray-200">
            <strong>Files</strong>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sr No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Upload Time</th>
                    <th scope="col">View File</th>
                    <th scope="col">Export File</th>
                </tr>
            </thead>
            <tbody>@php $i=0; @endphp
                @foreach ($files as $file)
                    <tr>
                        <th scope="row">{{ ++$i }}</th>
                        <td>{{ $file->name }}</td>
                        <td>{{ $file->created_at }}</td>
                        <td>
                            <a href="{{ route('file.viewFile', ['file' => $file->id]) }}"><button type="button"
                                    class="btn btn-primary">View</button></a>
                        </td>
                        <td>
                            <a href="{{ route('file.export-file', ['file' => $file->id]) }}"><button type="button"
                                    class="btn btn-primary">Download</button></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="">
            <a href="{{ route('file.importView') }}" class="btn btn-success">Import File</a>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success">
                <strong>{{ Session::get('success') }}</strong>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>{{ implode('', $errors->all(':message')) }}</strong>
            </div>
        @endif
    </div>
    </div>
@stop
