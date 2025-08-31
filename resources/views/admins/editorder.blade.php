@extends('layouts.admin')

@section('content')

 <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Edit Order#{{$order->id}} </h5>
          <form method="POST" action="{{route('update.order',$order->id)}}" enctype="multipart/form-data">
            @csrf
            <p>Current Status is <b>{{$order->status}}</b></p>
                <div class="form-outline mb-4 mt-4">
                  <select name="status" class="form-select  form-control" aria-label="Default select example">
                    @if($order->status === "Delivered")
                     <option value="Processing">Processing</option>
                     <option value="Delivered" selected>Delivered</option>
                    @else
                     <option value="Processing" selected>Processing</option>
                    <option value="Delivered">Delivered</option>
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
