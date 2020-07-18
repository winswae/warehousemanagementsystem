@extends('adminlte::page')

@section('title', 'Show')

@section('content_header')
    <h1>Show</h1>
@stop

@section('content')
<div class="row">
    <div class="container-fluid">
        <div class="container-fluid">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Name</th>
                <td>{{ $warehouse->name }}</td>
            </tr>
             <tr>
                <th>Description</th>
                <td>{{ $warehouse->description }}</td>
            </tr>

            <tr>
                <th>Location</th>
                <td>{{ $warehouse->location }}</td>        
            </tr>
            <tr>
                <th>Marla</th>
                <td>{{ $warehouse->marla }}</td>
            </tr>
            <tr>
                <th>Room</th>
                <td>{{ $warehouse->room }}</td>
            </tr>
            <tr>
                <th>Renter</th>
                <td>{{ $warehouse->renter_id }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $warehouse->status }}</td>
            </tr>
            <tr>
                <th>Service</th>
                <td><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#add_service">Add service</button></td>
            </tr>
            <tr>
                <th>TimeStamp</th>
                <td>{{ $warehouse->created_at }}</td>
            </tr>
        </table>
    </div>
</div>
</div>


<!-- Service Modal -->
<div id="add_service" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <form action="{{route('subscribe_service')}}" method="POST">
      @csrf
      <div class="modal-body">
        @foreach($services as $service)
            <label>{{$service->name}}</label> &nbsp <input type="checkbox" value="{{$service->id}}" name="service_id">
        @endforeach
        <input type="hidden" name="warehouse_id" value="{{$warehouse->id}}">
      </div>
      <div class="modal-footer">
        <input type="submit" value="Add" ><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>

@stop

@section('css')

    <link rel="stylesheet" href="/css/admin_custom.css">
	
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop