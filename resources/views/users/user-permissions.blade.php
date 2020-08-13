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
                            <h3 class="page-title">Edit Permissions of user - {{ $user->name }}</h3>
                        </div>

                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            @endif
                        @endforeach
                        
                        <form action="{{ url()->current() }}" method="post" class="mb-4">
                            @csrf
                            
                            @foreach ($permissions as $permission)
                            <div class="form-check form-control-lg mb-2">
                                <label class="form-check-label"> 
                                    <input type="checkbox" @if($user->can($permission)) checked @endif onchange="updatePermission('{{ $permission }}', '{{ $user->id }}', this)" data-plugin="switchery" data-color="#1bb99a" data-size="small">
                                    {{ ucfirst($permission) }} 
                                </label>
                            </div>
                            @endforeach

                            <div class="col">
                                <div class="text-right">
                                    <a href="/users" class="btn btn-success btn-block waves-effect waves-light"> <span>Back</span> </a>
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
        function updatePermission(permission, userId, checkbox) {
            $.ajax({
                type: 'post',
                url: '{{ url()->current() }}/update-permission',
                data: {
                    'permission': permission,
                    'add': (checkbox.checked) ? '1' : '0',
                    '_token': "{{ csrf_token() }}",
                },
                success: function(data){
                    console.log(data);
                },
                error: function(errors) {
                    console.log(errors);
                }

            });
        }
    </script>
@endsection
