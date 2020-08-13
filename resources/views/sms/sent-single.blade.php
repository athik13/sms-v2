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
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="/sms/sent/">Single SMS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sms/sent/group">Group SMS</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="group" role="tabpanel" aria-labelledby="group-tab">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            @role('admin')
                                            <th>User</th>
                                            @endrole
                                            <th>Sender Id</th>
                                            <th>Message</th>
                                            <th>Phone Number</th>
                                            <th>State</th>
                                            <th>Sent At</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($single_messages as $message)
                                        <tr>
                                            @role('admin')
                                            <td>{{ $message->user->name }}</td>
                                            @endrole
                                            <td>{{ $message->sender_id }}</td>
                                            <td>{{ $message->message }}</td>
                                            <td>{{ $message->phone_number }}</td>
                                            <td>
                                                <?php
                                                    if($message->success == '1') {
                                                        echo 'Message sent successfully';
                                                    }
                                                    if($message->error == '1') {
                                                        echo 'Message failed to send. <br>';
                                                        echo $message->error_message;
                                                    }

                                                ?>
                                                @if($message->success == '0' AND $message->error == '0') The message is being sent @endif
                                            </td>
                                            <td>{{ $message->created_at->format('F d, Y h:m a') }}</td>
                                            <td class="text-center">
                                                <a href="{{ url()->current() }}/delete/{{ $message->id }}" class="btn btn-danger" onclick="return confirm('Are you sure you would like to delete this? This process cannot be reversed.')">x</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $single_messages->links() }}
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
