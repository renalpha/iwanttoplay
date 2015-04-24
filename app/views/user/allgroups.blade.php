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
                    <table class="table table-striped">
                    @foreach($playlistsArray as $playlistA)
                    <tr>
                        <td><a href="/playlist/{{ json_decode($playlistA)->slug }}/play">{{ json_decode($playlistA)->name }}</a></td>
                    </tr>
                    @endforeach
                    </table>
                </div>
        </div>

    </div>

</div>
@stop

@section('bottomscripts')

@stop