@extends('layouts.app')

@section('css')

@endsection

@section('content')

<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @include('includes.nav-pills')
                </div>

                <div class="card-body">
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))


                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            </p>

                            @endif
                        @endforeach

                    </div>
                    <h5>Add New Number to SMS Group</h5>
                    <form method="POST" enctype="multipart/form-data" action="{{ url()->current() }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Example: Ali" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number *</label>
                            <input class="form-control" id="phoneNumber" name="phoneNumber" type="tel" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Number</button>
                        </div>
                    </form>
                    <br>
                    <hr>
                    <br>
                    <h5>All Numbers of SMS Group - {{ $smsGroup->group_name }}</h5>
                    <table id="data-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Phone Numbers</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($numbers as $number)
                            <tr>
                                <td>{{ $number->name }}</td>
                                <td>{{ $number->phone_number }}</td>
                                <td>
                                    <button class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $numbers->links() }}
                </div>
                <!-- end inbox-rightbar-->

                <div class="clearfix"></div>
            </div>

        </div> <!-- end Col -->

    </div><!-- End row -->


</div> <!-- end container -->

@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable();
    } );
</script>
@endsection
