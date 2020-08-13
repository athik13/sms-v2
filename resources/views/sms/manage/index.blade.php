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
                    <h5>Add New SMS Group</h5>
                    <form class="mb-4" method="POST" enctype="multipart/form-data" action="{{ url()->current() }}">
                        @csrf
                        <div class="form-group">
                            <label for="groupName">Group Name *</label>
                            <input type="text" class="form-control" id="groupName" name="groupName" placeholder="Example: Customers" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Group</button>
                        </div>
                    </form>

                    
                    <hr>
                    
                    <h5 class="mt-4">All SMS Groups</h5>
                    <table id="data-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>Group Name</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$smsGroups->isEmpty())
                            
                                @foreach($smsGroups as $group)
                                <tr>
                                    <td>{{ $group->group_name }}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{ url()->current() }}/{{ $group->id }}">Manage Numbers</a>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td class="text-center" colspan="2">No Groups Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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
