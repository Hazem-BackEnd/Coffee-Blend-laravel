@extends('layouts.admin')

@section('content')

 <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Edit Booking#{{$booking->id}} </h5>
          <form method="POST" action="{{route('update.booking',$booking->id)}}" enctype="multipart/form-data">
            @csrf
            <p>Current Status is <b>{{$booking->status}}</b></p>
                <div class="form-outline mb-4 mt-4">
                  <select name="status" class="form-select  form-control" aria-label="Default select example">
                    @if($booking->status === "Booked")
                     <option value="Processing">Processing</option>
                     <option value="Booked" selected>Booked</option>
                    @else
                     <option value="Processing" selected>Processing</option>
                    <option value="Booked">Booked</option>
                    @endif
                  </select>
                </div>

                <br>



                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Change</button>


              </form>

            </div>
          </div>
        </div>
      </div>

@endsection
