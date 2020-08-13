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
                    <div class="inbox-rightbar">
                        <div class="col-12">
                            <h3 class="page-title">Manage Users</h3>
                        </div>

                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                        
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Messages Left</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->getRoleNames() }}</td>
                                    <td>
                                        @if ($user->hasRole('admin'))
                                            Unlimited
                                        @else
                                            {{ $user->messages_left }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->hasRole('admin'))
                                        <a href="" class="btn btn-success disabled" disabled="disabled">Modify Message Left</a>
                                            @if ($user->id !== 1)
                                                <a href="{{ url()->current() }}/remove-role/{{ $user->id }}/admin" class="btn btn-info">Remove from Admin</a>
                                            @endif
                                        @else
                                            <a href="{{ url()->current() }}/add-message/{{ $user->id }}" class="btn btn-success">Modify Message Left</a>
                                            <a href="{{ url()->current() }}/add-role/{{ $user->id }}/admin" class="btn btn-info">Make Admin</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

        </div> <!-- end Col -->

    </div><!-- End row -->


</div> <!-- end container -->

@endsection

@section('script')
    <script src="/js/sms_counter.min.js"></script>

    <script>
        $('#message').countSms('#sms-counter');
    </script>
@endsection
