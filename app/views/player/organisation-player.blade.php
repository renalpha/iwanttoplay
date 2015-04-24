@extends('...layouts.mainplayer')

@section('name')
{{ $team->name }}
@stop

@section('content')
<div class="container">
            @if(Session::has('voted-status'))
                 <div class="alert alert-success">
                        <ul>
                            <li>{{  Session::get('voted-status') }}</li>
                        </ul>
                    </div>
               @endif
    <div class="row">
        <div class="col-md-3">
            <div id="playlist-list">

            </div>

            @if($userismember == false && Sentry::check())
            <div id="add-track" class="widget white">
            <div id="invitecode">
            @if(Session::has('invite-status'))
                 <div class="alert alert-info">
                        <ul>
                            <li>{{  Session::get('invite-status') }}</li>
                        </ul>
                    </div>
               @endif
            {{ Form::open(array('url' => '/playlist/invited/'.$team->playlist->first()->id)) }}
                    <div class="inline-form">
                    <label class="c-label">Invite code</label><input id="invitecode" name="invitecode" class="input-style" type="text" placeholder="Fill in the invite code!" value="{{ Input::old('invitecode') }}">
                    </div>

                    <div class="inline-form">
                    <label class="c-label">Join now</label><input id="submit" name="submit" class="input-style" type="submit" value="Join playlist">
                    </div>
            {{ Form::close() }}
            </div>
            </div>
            @endif
        </div>
        <div class="col-md-6">
                <div id="player">

                </div>

                    <?php
                    $supportcookie = Cookie::get('dontshowvote'.$team->playlist->first()->id);
                    ?>
                    @if(!isset($supportcookie))
                    @if($userismember == false)
                                    <div id="add-track" class="widget white">
                    <h3>Support us!</h3>
                                        <p>Click the button below to support us! Your vote inspire us!</p>
                    {{ Form::open(array('url' => '/playlist/vote/'.$team->playlist->first()->id)) }}

                    <div class="inline-form">
                    <label class="c-label">SUPPORT {{ $team->playlist->first()->name }}</label><input id="submit" name="submit" class="input-style" type="submit" value="VOTE">
                    </div>
                    {{ Form::close() }}
                    </div>
                    @endif
                    @endif

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

                @if($userismember == true)
                <div id="add-user" class="widget white">
                    @if(Session::has('add-user-status'))
                    <div class="alert alert-info">
                        <ul>
                            <li>{{  Session::get('add-user-status') }}</li>
                        </ul>
                    </div>
                    @endif
                    {{ Form::open(array('url' => '/playlist/invite/'.$team->playlist->first()->id)) }}
                    <div class="inline-form">
                                        <div class="alert alert-info" id="display-invitation-users">
                                            <ul>
                                                <li>
                                                <span id="add-info"></span>
                                                </li>
                                            </ul>
                                        </div>
                    <label class="c-label">E-Mail</label><input id="email-invitation" name="email-invitation" class="input-style" type="text" placeholder="Invite your friends by e-mail address." value="{{ Input::old('email') }}">
                    </div>

                    <div class="inline-form">
                    <label class="c-label">invite to contribute</label><input id="submit-invitation" name="submit" class="input-style" type="submit" value="Invite to contribute!" disabled>
                    </div>
                    {{ Form::close() }}
                </div>
                @endif

                @if($userismember == true)
                <div id="add-user" class="widget white">
                <p><strong>Invite your friends to signup and join your playlist with the code below.</strong></p>
                    <p class="invitecoder">{{ $team->playlist[0]->invitecode }}</p>
                    <div class="clear"></div>
                    <p>
                    <p><strong>Or instantly invite them via Facebook, code already included!</strong><br /><br /></p>
                    <a href="/user/fb/invite/{{ $team->playlist[0]->id }}" class="facebookbtn">Invite Facebook Friends</a>
                    </p>
                </div>
                @endif
        </div>
        <div class="col-md-3">
                <div class="playlist-stats stats">
                <i class="fa fa-thumbs-up white"></i><h3>Support</h3>
                </div>
	        <div class="widget white no-margin playlist-stats-widget">
	        <table class="table table-striped">
	        <tr>
	        <td><h3>{{ $team->playlist->first()->votes }} supporters</h3></td>
	        </tr>
	        </table>
	        </div>

	        <?php
                $currank = DB::table('playlists')->where('votes','>=',Playlist::find($team->playlist[0]->id)->votes)->count();
	        ?>
                <div class="playlist-stats stats">
                <i class="fa fa-bar-chart white"></i><h3>Stats</h3>
                </div>
                <div class="widget white no-margin playlist-stats-widget">
                <table class="table table-striped">
                <tr>
                <td><span class="dark rankno">#{{ $currank }} /</span></td><td><span class="rankinfo"><span class="rank-no-participants dark">out of # {{ $countplaylists }}</span><div class="clear"></div> <span class="competition-name dark">{{ $djranks[$currank] }}</span><div class="clear"></div> </span></td>
                </tr>
                </table>
                </div>
	        <div class="playlist-stats stats">
	        <i class="fa fa-play-circle white"></i><h3>Listeners</h3>
            <?php
            $site_id = Analytics::getSiteIdByUrl('http://www.getyoursitenoticed.com'); // return something like 'ga:11111111'
            $filters = array('filters' => 'ga:pagePath=~/playlist/'.$organisation_slug.'/*');
            $today = date('Y-m-d');
            $statsToday = (object) Analytics::query($site_id, $today, 'today', 'ga:visits', $filters);
            $currenturl = str_replace('http://getyoursitenoticed.com', '', Request::url());
            $visitorsToday = $statsToday->rows[0][0];

            $firstDayOfMonth = date('Y-m-01');
            $statsMonth = (object) Analytics::query($site_id, $firstDayOfMonth, 'today', 'ga:visits', $filters);
            $visitorsThisMonth = $statsMonth->rows[0][0];
            ?>

	        </div>
	        <div class="widget white no-margin playlist-stats-widget">
	        <table class="table table-striped">
	        <tr>
	        <td><span class="dark rankno">{{ (isset($visitorsToday)) ? $visitorsToday : 0; }} today</span><div class="clear"></div> <span>{{ (isset($visitorsThisMonth)) ? $visitorsThisMonth : 0 }} this month</span> </td>
	        </tr>

	        </table>
	        </div>

                <div class="playlist-stats stats">
                <i class="fa fa-user white"></i><h3>Members</h3>
                </div>
                <div class="widget white no-margin playlist-stats-widget">
                <table class="table table-striped">
                <tr>
                <td><span class="dark rankno">#{{ count($members) }} /</span></td><td><span class="rankinfo"><span class="rank-no-participants dark">collaborators</span><div class="clear"></div><div class="clear"></div> </span></td>
                </tr>
                </table>
                <table class="table table-striped">
                <tr>
                <td>
                <ul class="profilepics">
                <?php
                $counter = 0;
                ?>
                @foreach($members as $member)
                <?php
                $counter++;
                $user = User::find($member->user_id);
                $profilepic = (isset($user->fbid)) ? '<img src="http://graph.facebook.com/'.$user->fbid.'/picture?type=square" alt="'.$user->first_name.' " />' : '<img src="/images/noprofilepic.png" />';
                ?>
                <li>{{ $profilepic }}</li>
                @if($counter == 5)
                <div class="clear"></div>
                @endif
                @endforeach
                </ul>
                </td>
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
     * Click function to get and play Specific Track (YOUTUBE ONLY)
     *
     * Youtube only initiates its API for 1 specific video
     */
    $(document).ready(function() {

        /**
         * Reload list every 10 seconds
         */
                $("#playlist-list").load('/player/list/{{ $organisation_slug }}/{{ $tracknumber }}', function() {
                    var playtrackurl = $(this).find('#play-{{ $tracknumber }}').find('.trackurl').text();
                    var tracktype = $(this).find('#play-{{ $tracknumber }}').find('.tracktype').text();
                    var getNO = {{ $tracknumber }};

                    $(this).find('#play-{{ $tracknumber }}').addClass("activeplay");


                if(tracktype == 'youtube'){
                    var tag = document.createElement('script');
                    tag.src = "https://www.youtube.com/iframe_api?noext";
                    document.getElementsByTagName("head")[0].appendChild(tag);
                    var newurl = playtrackurl.replace("watch?v=", "embed/");

                    $('<iframe width="100%" height="400" id="youtube-video" enablejsapi="1" src="'+newurl+'?enablejsapi=1&autoplay=1" frameborder="0"></iframe>').appendTo('#player');

                    $("iframe").ready(function (){
                        // do something once the iframe is loaded
                        console.log('yo');
                        window.onYouTubeIframeAPIReady = function() {
                        console.log('initalized youtube');
                              player = new YT.Player('youtube-video');

                              player.addEventListener("onReady","onYouTubePlayerReady");
                              player.addEventListener("onStateChange", "onYouTubePlayerStateChange");
                        };

                        onYouTubePlayerStateChange = function (state) {
                        console.log('YT state changed');
                            if(state.data === 0){
                            getNO++;
                            $('#player').empty();
                            player = null;
                            tag = null;
                            $('#play-'+getNO).find('a.playMe').trigger('click');
                            }
                        };

                        onYouTubePlayerReady = function (){
                            console.log('YT im ready');
                        };
                    });
                }

                if(tracktype== 'soundcloud'){

                    console.log('Open SoundCloud API');

                    // resolve trackID
                    $.when(
                        $.getJSON('https://api.soundcloud.com/resolve.json?url='+encodeURIComponent(playtrackurl)+'&client_id=555dbd03d48c0ee9d1f75e95f262229d')
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
                                      $('#play-'+getNO).find('a.playMe').trigger('click');
                                       player = null;
                                  });
                                });
                              });
                            }
                          });
                        }

                    });
                }

                if(tracktype == 'mixcloud'){
                console.log(tracktype);
                console.log('Open mixcloud API');

                var replacedurlembd = playtrackurl.replace('https://www.mixcloud.com/', '');
                var mixclouddata = $.get(' http://api.mixcloud.com/'+replacedurlembd+'embed-json/', function(data, status){
                console.log();
                });

                var tag = document.createElement('script');
                tag.src = "//www.mixcloud.com/media/js/widgetApi.js";
                document.getElementsByTagName("head")[0].appendChild(tag);
                var trackurl = encodeURIComponent(playtrackurl);

                $('<iframe width="660" height="180" src="https://www.mixcloud.com/widget/iframe/?embed_type=widget_standard&amp;embed_uuid=4064da51-6e83-4ae4-bfae-ec8200c32193&amp;feed='+trackurl+'%2F&amp;hide_cover=1&amp;hide_tracklist=1&amp;replace=0" frameborder="0"></iframe>').appendTo('#player');


                var widget = Mixcloud.PlayerWidget(document.getElementById('mixcloudplayer'));


                widget.ready.then(function() {

                    var duration = widget.getDuration();
                    // Put code that interacts with the widget here
                    widget.getPosition().then(function(position) {
                        // "position" is the current position
                        console.log(position);
                        if(position == duration){
                        console.log('end');
                                  console.log('Finished Playing SoundCloud');
                                    // Do next auto click event
                                    getNO++;
                                      $('#play-'+getNO).find('a.playMe').trigger('click');
                                       player = null;
                        }
                    });
                });
                }

                });


                setInterval(function(){
                $("#playlist-list").load('/player/list/{{ $organisation_slug }}/{{ $tracknumber }}', function() {
                console.log('reload playlist');
                });

                }, 10000);

        /**
         * Invite existing user to this Group
         */
                $( "#email-invitation" ).bind("propertychange change click keyup input paste", function() {
                  console.log('change');
                    $.ajax({
                      method: "POST",
                      url: "/users/show/names",
                      data: { email: $('#email-invitation').val() }
                    })
                      .done(function( msg ) {
                     $('#display-invitation-users').show();
                     $('#add-info').text(msg);

                     if(msg == 'No user found'){
                     $('#submit-invitation').val('Not valid');
                     $('#submit-invitation').attr('disabled','disabled');
                     }else{
                     $('#submit-invitation').val('Add user to Playlist');
                     $('#submit-invitation').removeAttr('disabled');
                     }
                     });
                    return false;
                });

    });

    $(document).ready(function() {
        /**
         * Open the track when done loading
         */




    });


</script>
@stop