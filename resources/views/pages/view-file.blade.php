@extends('layouts.default')
@section('content')
    <div class="container mt-5 text-center">
        <div class="p-6 bg-white border-b border-gray-200">
            <strong>Files</strong>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    @foreach ($headings as $heading)
                    <th scope="col">{{$heading}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>@php $i=0; @endphp
                @foreach ($records as $key => $record)
                    <tr>
                        <th scope="row">{{ ++$i }}</th>
                        <td>{{$record}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
