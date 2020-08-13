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
                            <h3 class="page-title">Send a Single SMS</h3>
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
                                        <input class="form-control" id="senderId" name="senderId" type="text" placeholder="" class="form-control input-md" required="" >
                                        <small class="form-text text-muted">Enter a sender Id here. It must be a combination of letters and numbers, It cannot be more than 11 characters.</small>
                                        <small class="form-text text-muted">Note: US numbers cant receive alphanumeric sender id messages, for more information: <a target="_blank" href="https://support.twilio.com/hc/en-us/articles/223133767-International-support-for-Alphanumeric-Sender-ID">Read This</a></small>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="phoneNumber">Phone Number</label>
                                        <p class="text-muted" id="output">Please enter a valid number below</p>
                                        <input class="form-control" id="phoneNumber" type="tel" autocomplete="off" required>
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
                                        <button type="button" class="btn btn-danger waves-effect waves-light m-r-5"> <span>Reset</span></button>
                                        <button class="btn btn-primary waves-effect waves-light"> <span>Send</span></button>
                                    </div>
                                </div>

                            </form>
                        </div> <!-- end card-->

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
    <script src="/js/intlTelInput.min.js"></script>

    <script>
        $('#message').countSms('#sms-counter');
    
        var input = document.querySelector("#phoneNumber");
        var output = document.querySelector("#output");

        var iti = window.intlTelInput(input, {
            preferredCountries: ["us", "gb", "mv", "my"],
            hiddenInput: "phoneNumber",
            utilsScript: "/js/utils.js"
        });

        var handleChange = function() {
            var text = (iti.isValidNumber()) ? "International: " + iti.getNumber() : "Please enter a number below";
            var textNode = document.createTextNode(text);
            output.innerHTML = "";
            output.appendChild(textNode);
        };

        // listen to "keyup", but also "change" to update when the user selects a country
        input.addEventListener('change', handleChange);
        input.addEventListener('keyup', handleChange);
    </script>
@endsection
