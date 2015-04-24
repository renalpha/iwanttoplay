	        <div class="playlist-stats stats">
	        <i class="fa fa-music white"></i><h3>Playlist ( {{ count($tracks) }} )</h3>
	        </div>
	        <div class="widget white no-margin playlist-stats-widget">
	        <div class="scrollthis">
	        <div id="moveme">
	        <?php $i = 0;?>
                <ul class="ui-sortable">
                    <?php
                    $j = 1;
                    ?>
                    @if(isset($tracks))
                        @foreach($tracks as $track)
                            <li style="cursor: hand;" id="{{ $track->id }}-{{ $j++ }}">
                                <table class="table table-striped no-margin">
                                    <tr class="runitem-{{ $i++ }}" id="play-{{ $j }}">
                                    <td class="typeicon"><img src="/images/{{ $mediatypes[$track->type] }}" alt="Source Icon" class="sourceicon" /></td><td><a href="{{ $j }}" class="playMe"><span class="tracktype">{{ $track->type }}</span> <span class="trackurl">{{ $track->url }}</span> <span class="trackinfo"><span class="music-title dark">{{ $track->title }}</span><span class="music-artist dark">{{ $track->artist }}</span><div class="clear"></div> </span></a></td><td class="arrowicon"><i class="fa fa-play dark playbtnlist"></i>
                                    @if($userismember == true)
                                    <span class="closethis"><a href="#" id="remove-{{$track->id}}" class="removetrack">X</a></span>
                                    @endif</td>
                                    </tr>
                                </table>
                            </li>
                        @endforeach
                        @else
                            <li style="cursor: hand;">
                                <table class="table table-striped no-margin">
                                    <tr class="runitem-{{ $i++ }}">
                                    <td class="typeicon"></td><td></td><td class="arrowicon"></td>
                                    </tr>
                                </table>
                            </li>
                        @endif
                </ul>
                <div class="clear"></div>
	        </div>
	        </div>
	        </div>

<script type="text/javascript" src="/js/perfect-scrollbar.jquery.js"></script>
<script type="text/javascript">

    $(function () {
        $('#moveme').perfectScrollbar({
                suppressScrollX: true,
                minScrollbarLength: 50
        });

    });

    @if($userismember == true)
        $(document).ready(function() {

        $('.removetrack').click( function() {
        console.log('remove track');
        var trackid = $(this).attr('id');
        $(this).parent().parent().parent().remove();

        $.get( "/playlist/remove/{{ $organisation }}/"+trackid, function( data ) {
            console.log('removed');

        });

        return false;

        });

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
    @endif

    $(document).ready(function() {


        var currentRun = 0;
        var script = document.createElement("script");
        var trackurl = null;
        var getNO = null;
        var player = null;

        $(this).find('#play-{{ $currentid }}').addClass("activeplay");

        $('.playMe').click( function() {

        // remove PLAYER contents
        $('#player').empty();



        // get url
        trackurl = $(this).children('.trackurl').text();

            console.log('track selected');
            currentRun = $(this).parent().parent().attr('class');
            $(this).parent().parent().addClass("activeplay");
            getNO = $(this).attr('href');

            // select appr player and API
            if($(this).children('.tracktype').text() == 'soundcloud'){
                console.log('Open SoundCloud API');
                window.open(getNO, "_self");
            }

            // check if we got an youtube link and we will just refresh the page and open the player
            if($(this).children('.tracktype').text() == 'youtube'){
                console.log('Open Youtube API');
                window.open(getNO, "_self");
            };


        return false;
        });




    });

</script>