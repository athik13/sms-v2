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
                            <h3 class="page-title">Send Group SMS</h3>
                        </div>

                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                        
                        @if (!auth()->user()->hasRole('admin'))
                            <div class="col-md-12">
                                <h5 class="text-center"><b>Messages Left:</b> {{ auth()->user()->messages_left }}</h5>
                                <hr>
                            </div>
                        @endif
                        
                        <div class="mt-4">
                            <form class="form-horizontal" method="POST" autocomplete="off" action="{{ url()->current() }}">
                                @csrf
                                <div class="col">
                                    <div class="form-group">
                                        <label for="senderId">Sender id</label>
                                        <input class="form-control" id="senderId" maxlength="11" pattern="^(?=.*[a-zA-Z])(?=.*[a-zA-Z0-9])([a-zA-Z0-9 ]{1,11})$" name="senderId" type="text" placeholder="" class="form-control input-md" required="" title="Cannot Be Loner than 11 letter. Only letters and numbers allowed">
                                        <small class="form-text text-muted">Enter a sender Id here. It must be a combination of letters and numbers, It cannot be more than 11 characters.</small>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="groupId">Select Group from list:</label>
                                        <select class="form-control" id="groupId" name="groupId" autocomplete="off" required>
                                            <option value="0" selected>No Group Selected</option>
                                            @foreach ($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="phoneNumber">Additional Phone Numbers</label>
                                        <input class="form-control" id="phoneNumbers" name="phoneNumbers" type="name" placeholder="" autocomplete="off">
                                        <p class="help-block">Enter the numbers with the country code here seperated by (comma ,) Eg: 9991234,7771234,9999123,77771234</p>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea style="font-size: 15px" class="form-control" rows="4" id="message" name="message" autocomplete="off" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 text-center">
                                            <ul id="sms-counter" style="list-style: none;">
                                                <li style="display: inline-block;"><b>Length:</b> <span class="length"></span></li>
                                                <li style="display: inline-block;"><b>Messages:</b> <span class="messages"></span></li>
                                                <li style="display: inline-block;"><b>Per Message:</b> <span class="per_message"></span></li>
                                                <li style="display: inline-block;"><b>Remaining:</b> <span class="remaining"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-b-0">
                                    <div class="text-right">
                                        <button type="button" class="btn btn-danger waves-effect waves-light m-r-5"> <span>Reset</span> <i class="mdi mdi-delete"></i></button>
                                        <button class="btn btn-primary waves-effect waves-light"> <span>Send</span> <i class="mdi mdi-send ml-2"></i> </button>
                                    </div>
                                </div>

                            </form>
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
