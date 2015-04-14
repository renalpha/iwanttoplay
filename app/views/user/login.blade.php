@extends('...layouts.mainplayer')

@section('name')

@stop

@section('background')

<video autoplay loop poster="/images/mixer-bg.jpg" id="bgvid">
<source src="/images/c9b4b697328aa459ee11da41725ad439.mp4" type="video/mp4">
</video>

@stop

@section('content')
<div class="container">

    <div class="row">

        <div class="col-md-12">

                <div id="add-track" class="widget white">
                    @if($errors->has())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() AS $error)
                            <li>{{  $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(Session::has('status'))
                    <div class="alert alert-info">
                        <ul>
                            <li>{{  Session::get('status') }}</li>
                        </ul>
                    </div>
                    @endif
                <h3>Welcome back!</h3>
                    <p>Not an member yet? <a href="/signup">Create your own account here</a>.</p>
                    {{ Form::open(array('url' => Request::path())) }}
                                                        <div class="panel-heading">Account Information
                                                        </div>


                                                        <div class="inline-form">
                                                        <label class="c-label">Username (E-mail)</label><input id="email" name="email" class="input-style" type="text" placeholder="yourmail@address.com" value="{{ (isset($user->email)) ? $user->email : Input::old('email') }}">
                                                        </div>

                                                        <div class="inline-form">
                                                        <label class="c-label">Password</label><input id="password" name="password" class="input-style" type="password" placeholder="Your secret password" value="{{ (isset($user->password)) ? $user->password : Input::old('password') }}">
                                                        </div>

                                                        <div class="inline-form">
                                                        <label class="c-label">LETS GO!</label><input id="submit" name="submit" class="input-style" type="submit" value="Login">
                                                        </div>
                    {{ Form::close() }}

                </div>
        </div>

    </div>

</div>
@stop

@section('bottomscripts')

@stop