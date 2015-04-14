@extends('...layouts.mainplayer')

@section('name')
{{ $team->name }}
@stop

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-3">
	        <div class="playlist-stats stats">
	        <i class="fa fa-music white"></i><h3>Playlist ( {{ count($tracks) }} )</h3>
	        </div>
	        <div class="widget white no-margin playlist-stats-widget">
	        <div id="moveme">
	        <?php $i = 0;?>
                <ul class="ui-sortable">
                    <?php
                    $j = 1;
                    ?>
                        @foreach($tracks as $track)
                            <li style="cursor: hand;" id="{{ $track->id }}-{{ $j++ }}">
                                <table class="table table-striped no-margin">
                                    <tr class="runitem-{{ $i++ }}">
                                    <td class="typeicon"><img src="/images/{{ $mediatypes[$track->type] }}" alt="Source Icon" class="sourceicon" /></td><td><a href="#" class="playMe"><span class="tracktype">{{ $track->type }}</span> <span class="trackurl">{{ $track->url }}</span> <span class="trackinfo"><span class="music-title dark">{{ $track->title }}</span><span class="music-artist dark">{{ $track->artist }}</span><div class="clear"></div> </span></a></td><td class="arrowicon"><i class="fa fa-play dark playbtnlist"></i></td>
                                    </tr>
                                </table>
                            </li>
                        @endforeach
                </ul>
	        </div>
	        </div>
        </div>
        <div class="col-md-6">
                <div id="player">

                </div>

                <div id="add-track" class="widget white">
                @if($userismember == false)
                <h3>Collaborate with your colleagues and friends!</h3>
                    <p>Member of this group? <a href="/login">Login</a> to start submitting tracks and get your group on number one! Or you could always start your own group. <a href="/signup">Signup here!</a> </p>
                @else

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

                    {{ Form::open(array('url' => '/playlist/add/'.$team->playlist->first()->id)) }}
                    <div class="inline-form">
                    <label class="c-label">Title</label><input id="title" name="title" class="input-style" type="text" placeholder="Track Title" value="{{ Input::old('title') }}">
                    </div>

                    <div class="inline-form">
                    <label class="c-label">Artist</label><input id="artist" name="artist" class="input-style" type="text" placeholder="Artist Name" value="{{ Input::old('artist') }}">
                    </div>

                    <div class="inline-form">
                    <label class="c-label">Link</label><input id="link" name="link" class="input-style" type="text" placeholder="Place Youtube or Soundcloud URL." value="{{ Input::old('link') }}">
                    </div>

                    <div class="inline-form">
                    <label class="c-label">Add</label><input id="submit" name="submit" class="input-style" type="submit" value="Add to Playlist">
                    </div>
                    {{ Form::close() }}
                @endif
                </div>
        </div>
        <div class="col-md-3">
	        <div class="playlist-stats stats">
	        <i class="fa fa-thumbs-up white"></i><h3>Supporters</h3>
	        </div>
	        <div class="widget white no-margin playlist-stats-widget">
	        <table class="table table-striped">
	        <tr>
	        <td><img src="/images/soundcloud-icon.png" alt="SoundCloud" class="sourceicon" /></td><td><span class="trackinfo"><span class="music-title dark">Hell March</span><span class="music-artist dark">Frank Klepacki</span><div class="clear"></div> </span></td><td><i class="fa fa-play dark playbtnlist"></i></td>
	        </tr>
	        </table>
	        </div>
	        <div class="playlist-stats stats">
	        <i class="fa fa-play-circle white"></i><h3>Listeners</h3>
	        </div>
	        <div class="widget white no-margin playlist-stats-widget">
	        <table class="table table-striped">
	        <tr>
	        <td><img src="/images/soundcloud-icon.png" alt="SoundCloud" class="sourceicon" /></td><td><span class="trackinfo"><span class="music-title dark">Hell March</span><span class="music-artist dark">Frank Klepacki</span><div class="clear"></div> </span></td><td><i class="fa fa-play dark playbtnlist"></i></td>
	        </tr>

	        </table>
	        </div>
                <div class="playlist-stats stats">
                <i class="fa fa-bar-chart white"></i><h3>Stats</h3>
                </div>
                <div class="widget white no-margin playlist-stats-widget">
                <table class="table table-striped">
                <tr>
                <td><span class="dark rankno">#1 /</span></td><td><span class="rankinfo"><span class="rank-no-participants dark">out of # 10</span><div class="clear"></div> <span class="competition-name dark">Radio DJ</span><div class="clear"></div> </span></td>
                </tr>
                </table>
                </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">

        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>
@stop

@section('bottomscripts')
<script type="text/javascript">


    /**
     * Click function to get and play Specific Track
     */
    $(document).ready(function() {

        var currentRun = 0;
        var script = document.createElement("script");
        var script2 = document.createElement("script");
        var trackurl = null;
        var getNO = null;
        var player = null;

        $('.playMe').click( function() {
            getNO = null;
            currentRun = $(this).parent().parent().attr('class');
            getNO = currentRun.replace('runitem-', '');

            console.log(currentRun);
            // remove PLAYER contents
            $('#player').empty();

            // get url
            trackurl = $(this).children('.trackurl').text();

            // select appr player and API
            if($(this).children('.tracktype').text() == 'soundcloud'){

                console.log('Open SoundCloud API');

                // resolve trackID
                $.when(
                    $.getJSON('https://api.soundcloud.com/resolve.json?url='+encodeURIComponent(trackurl)+'&client_id=555dbd03d48c0ee9d1f75e95f262229d')
                ).done( function(trackinfo) {
                    // add to player
                    $('<iframe width="100%" height="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'+trackinfo.id+'&color=0066cc&auto_play=true"></iframe>').appendTo('#player');

                    player = player = $('iframe[src*="soundcloud"]');

                    if ( player.length > 0 ) {
                      $.getScript('//w.soundcloud.com/player/api.js', function (data, status) {
                        if ( status === 'success' ) {
                            player.each(function (index) {
                            var sc = SC.Widget(this);
                            sc.bind(SC.Widget.Events.READY, function() {
                              sc.bind(SC.Widget.Events.FINISH, function () {
                              console.log('Finished Playing SoundCloud');
                                // Do next auto click event
                                getNO++;
                                   $('.runitem-'+getNO).find('a').trigger('click');

                                   player = null;
                              });
                            });
                          });
                        }
                      });
                    }

                });
            }

            if($(this).children('.tracktype').text() == 'youtube'){
                console.log('Open Youtube API');

                var tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                var newurl = trackurl.replace("watch?v=", "embed/");

                $('<iframe width="100%" height="100%" id="youtube-video" enablejsapi="1" src="'+newurl+'?enablejsapi=1&autoplay=1" frameborder="0"></iframe>').appendTo('#player');

                window.onYouTubeIframeAPIReady = function() {
                console.log('initalized youtube');
                      player = new YT.Player('youtube-video');

                      player.addEventListener("onReady","onYouTubePlayerReady");
                      player.addEventListener("onStateChange", "onYouTubePlayerStateChange");
                }

                onYouTubePlayerStateChange = function (state) {
                    if(state.data === 0){
                    getNO++;
                    $('.runitem-'+getNO).find('a').trigger('click');
                    getNO = null;
                    player = null;
                    }
                }

                onYouTubePlayerReady = function (){

                }

            }



            if($(this).children('.tracktype').text() == 'spotify'){
                console.log('Open Spotify API');
                script.type = "text/javascript";

                script.src = "//www.getyoursitenoticed.com/spotify-web-api.js";
                document.getElementsByTagName("head")[0].appendChild(script);
            }

        });

        return false;
    });




</script>
@if($userismember == true)
<script src="/js/jqueryui-1.10.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    console.log('drag init');
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$(function() {
		$("#moveme ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
		console.log('order');
            var order = $(this).sortable("serialize");
            //console.log(order);
			var liIds = $('#moveme ul li').map(function(i,n) {
                return $(n).attr('id');
            }).get().join(',');

			$.post("/playlist/order/{{  $team->playlist->first()->id  }}", { formData: liIds }, function(theResponse){
				console.log(theResponse);
			});
		}
		});
	});

});
</script>
@endif
@stop