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
                    @if(isset($user))
                    <h3>Welcome back!</h3>
                    <p>The PlayLists below are subscribed to your account!<br /><br /><br /></p>
                    @else
                    <h3>Welcome to EXdeliver - PlayList!</h3>
                    <p>This is the resource to start creating your own playlists and put them to the public!</p>
                    <div class="clear"></div>
                    <div class="sfeerbg">
                        <h1>Let the world hear your music taste!</h1>
                        <h1><a href="/signup">SIGN UP!</a></h1><div class="clear"></div>
                        <div class="clear"></div>
                    </div>
                    @endif
                </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
    <div class="col-md-12">
                    <div id="add-track" class="widget white">
                    <h3>Playlists</h3>
                    <p>Check out the Playlists below and <strong>support</strong> their group, tell them you think they are <strong>awesome</strong>.<br /><br /></p>

                    <table class="table table-striped">
                    <tr>
                    <td><strong>Groups</strong></td>
                    </tr>
                    @foreach($playlistsArray as $playlistA)
                    <tr>
                        <td><a href="/playlist/{{ json_decode($playlistA)->slug }}/play">{{ json_decode($playlistA)->name }}</a></td>
                    </tr>
                    @endforeach
                    </table>
                    @if(isset($user))
                    <p><h3>Create Playlist</h3></p>
                    {{ Form::open(array('url' => Request::path())) }}
                        <div class="inline-form">
                        <label class="c-label">Name</label><input id="name" name="name" class="input-style" type="text" placeholder="Team My Office" value="{{ Input::old('name') }}">
                        </div>
                        <div class="inline-form">
                        <label class="c-label">Start composing</label><input id="submit" name="submit" class="input-style" type="submit" value="Start Composing">
                        </div>
                    {{ Form::close() }}
                    @endif
                </div>
        </div>
    </div>


</div>
@stop

@section('bottomscripts')

@stop