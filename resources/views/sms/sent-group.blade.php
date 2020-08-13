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
                    <div class="row">
                        <div class="col">
                            <small>Click on table row to view details</small>
                        </div>
                    </div>
                    <div class="inbox-rightbar">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link" href="/sms/sent/">Single SMS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="/sms/sent/group">Group SMS</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="group" role="tabpanel" aria-labelledby="group-tab">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sender Id</th>
                                            <th>Message</th>
                                            <th>State</th>
                                            <th>Sent At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($group_messages as $message)
                                        <tr onclick="window.location='/sms/sent/group/{{ $message->id }}';">
                                            <td>{{ $message->sender_id }}</td>
                                            <td>{{ $message->message }}</td>
                                            <td>{{ $message->state }}</td>
                                            <td>{{ $message->created_at->format('F d, Y h:m a') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $group_messages->links() }}
                            </div>
                        </div>
                        </div> <!-- end card-->

                    </div>
                </div>
                <!-- end inbox-rightbar-->

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
