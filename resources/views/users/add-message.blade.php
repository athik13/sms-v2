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
                            <h3 class="page-title">Modify Message Left to user - {{ $user->name }}</h3>
                        </div>

                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                        
                        <form action="{{ url()->current() }}" method="post" class="mb-4">
                            @csrf
                            <div class="col">
                                <div class="form-group">
                                    <label for="messages_left">Messages Left</label>
                                    <input class="form-control" name="messages_left" value="{{ $user->messages_left }}">
                                    <small class="form-text text-muted">Modify the messages left for this user.</small>
                                </div>
                            </div>

                            <div class="col">
                                <div class="text-right">
                                    <button class="btn btn-success btn-block waves-effect waves-light"> <span>Save</span> <i class="mdi mdi-send ml-2"></i> </button>
                                </div>
                            </div>
                        </form>

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
