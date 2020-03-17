@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="tl-form">
            <div class="panel panel-default">
                <div class="tl-form-logo">
                    <a href="{{url('/')}}"><img src="{{url('/')}}/public/tl_admin/dist/img/logo.png" alt="" class="img-responsive"></a>
                </div>
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                                <label for="">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif

                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="tl-sendemail">
                                <button type="submit" class="tl-form-submit hvr-sweep-to-right">
                                    Send Password Reset Link
                                </button>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
