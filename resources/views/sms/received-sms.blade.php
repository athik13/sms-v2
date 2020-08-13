@extends('layouts.app')

@section('css')

@endsection

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @include('includes.nav-pills')
                </div>

                <div class="card-body">
                    <div class="inbox-rightbar">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Webhook URL</label>
                                    <input class="form-control form-control-sm" type="text" value="{{ url('/nexmo/webhook/receive/sms') }}" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <h3 class="page-title">View all received messages</h3>
                            </div>
                            <div class="col-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Message</th>
                                            <th>Type</th>
                                            <th>Received At</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($received as $sms)
                                        <tr>
                                            <td>{{ $sms->from }}</td>
                                            <td>{{ $sms->to }}</td>
                                            <td>{{ $sms->message }}</td>
                                            <td>{{ $sms->type }}</td>
                                            <td>{{ $sms->timestamp }}</td>
                                            <td class="text-center">
                                                <a href="{{ url()->current() }}/delete/{{ $sms->id }}" class="btn btn-danger" onclick="return confirm('Are you sure you would like to delete this? This process cannot be reversed.')">x</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $received->links() }}
                            </div>
                        </div>
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
