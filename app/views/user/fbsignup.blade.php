@extends('...layouts.mainplayer')

@section('name')

@stop

@section('background')

<video autoplay loop poster="/images/mixer-bg.jpg" id="bgvid">
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
                <h3>Collaborate with your colleagues and friends!</h3>
                    <p>Start creating the greatest Playlist you have ever build with your colleagues and friends! Already got an account? Please <a href="/login">login here</a>.</p>
                    {{ Form::open(array('url' => '/signup')) }}
                                                        <input type="hidden" name="fbid" value="{{ $facebookapi->id }}" />
                                                        <div class="panel-heading">Account Information
                                                        </div>

                                                        <div class="inline-form">
                                                        <label class="c-label">Group name</label><input id="groupname" name="groupname" class="input-style" type="text" placeholder="Our Slick Team Name" value="{{ Input::old('groupname') }}">
                                                        </div>

                                                        <div class="inline-form">
                                                        <label class="c-label">First name</label><input id="first_name" name="first_name" class="input-style" type="text" placeholder="Tim" value="{{ (isset($facebookapi->first_name)) ? $facebookapi->first_name : Input::old('first_name') }}">
                                                        </div>

                                                        <div class="inline-form">
                                                        <label class="c-label">Last name</label><input id="last_name" name="last_name" class="input-style" type="text" placeholder="Berg" value="{{ (isset($facebookapi->last_name)) ? $facebookapi->last_name : Input::old('last_name') }}">
                                                        </div>

                                                        <div class="inline-form">
                                                        <label class="c-label">Username (E-mail)</label><input id="email" name="email" class="input-style" type="text" placeholder="yourmail@address.com" value="{{ (isset($facebookapi->email)) ? $facebookapi->email : Input::old('email') }}">
                                                        </div>

                                                        <div class="inline-form">
                                                        <label class="c-label">Terms of agreement</label><input id="terms" name="terms" class="input-style" type="checkbox" value="1" style="float: left; width: 50px;"> <p style="float: left; width: auto; padding:10px 0px;">In order to proceed you need to agree with our <a href="#" target="_blank">terms of agreement</a>.</p>
                                                        </div>
                                                        <input type="hidden" name="authtype" value="facebook" />
                                                        <div class="inline-form">
                                                        <label class="c-label">Start composing your Playlist</label><input id="submit" name="submit" class="input-style" type="submit" value="Signup to Playlist">
                                                        </div>
                    {{ Form::close() }}

                </div>
        </div>

    </div>

</div>
@stop

@section('bottomscripts')

@stop