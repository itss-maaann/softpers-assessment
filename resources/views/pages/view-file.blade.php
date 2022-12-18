@extends('layouts.default')
@section('content')
    <div class="container mt-5 text-center">
        <div class="p-6 bg-white border-b border-gray-200">
            <strong>{{$file_name}}</strong>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sr No</th>
                    @foreach ($headings as $heading)
                        <th scope="col">{{ $heading['column_name'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>@php
                $x = 0;
                $first_column = $headings[0]['id'];
                $last_column = $headings[count($headings) - 1]['id'];
            @endphp
                @foreach ($cells as $cell)
                    @if ($cell['column_id'] == $first_column)
                        <tr>
                            <th scope="row">{{ ++$x }}</th>
                    @endif
                    <td>{{ $cell['value'] }}</td>
                    @if ($cell['column_id'] == $last_column)
                        </tr>
                    @endif
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
