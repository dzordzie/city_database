@extends('layout.master')

@section('content')

<div class="section-city-detail">
    <div class="container d-flex flex-column align-items-center justify-content-center">
        <table class="detail-table">
            <tbody>
                @foreach ($data as $key => $value)
                    @if (!is_null($value) && $value !== '')
                        <tr>
                            <td class="fw-bold">{{ $key }}</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection