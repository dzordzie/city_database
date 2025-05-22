@extends('layout.master')

@section('content')

<div class="section-city-detail">
    <div class="container">
        <h3 class="sub-heading text-center mb-5">Detail obce</h3>
        <div class="row mx-1 mx-md-0">
            <div class="col-12 col-md-8 col-lg-6 order-2 order-md-1 content-table">
                <div class="content-table_wrapper d-flex alignt-items-center justify-content-center">
                    <table class="detail-table">
                        <tbody>
                            @foreach ($data as $key => $value)
                                @if (!is_null($value) && $value !== '')
                                    <tr class="d-block d-sm-table-row">
                                        <td class="fw-bold d-block d-sm-table-cell text-center text-sm-start">{{ $key }}</td>
                                        <td class="d-block d-sm-table-cell text-center text-sm-start">
                                            @if (is_array($value))
                                                <ul class="list-unstyled m-0">
                                                    @foreach ($value as $email)
                                                        <li>{{ $email }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-6 order-1 order-md-2 content-additional">
                <div class="content-aditional_info w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="coat-of-arms_wrapper mt-2">
                        <img src="{{ asset($city->coat_of_arms_image) }}" alt="{{ $city->name }}">
                    </div>
                    <h2 class="sub-district_name text-primary fw-bold mt-3">{{ $city->name }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection