@extends('layouts.app')

@section('content')

<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{asset('assets/images/bg_3.jpg')}});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">My Orders</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home</a></span> <span>My Orders</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-cart">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table table-dark w-100" style="min-width: 1000px;">
                        <thead style="background-color:#c49b63; height:50px">
                            <tr class="text-center ">
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($bookings->count() > 0)
                                @foreach ($bookings as $booking)
                                    <tr class="text-center" style="height:140px;">
                                        <td>{{$booking->first_name}}</td>
                                        <td>{{$booking->last_name}}</td>
                                        <td>{{$booking->date}}</td>
                                        <td>{{$booking->time}}</td>
                                        <td>{{$booking->phone}}</td>
                                        <td>{{$booking->status}}</td>
                                        <td>
                                            @if($booking->status == "Booked")
                                                <a class="btn btn-primary" href="{{route('write.reviews')}}">Write review</a>
                                            @else
                                            <button class="btn btn-dark" disabled href="#">Write review</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <p class="alert alert-success m-0">You have no products in cart just yet</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
