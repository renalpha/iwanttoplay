    <script src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js" type="text/javascript"></script>


<div id="myytplayer">

</div>

<script type="text/javascript">

                console.log('Open Youtube API');

                var tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api?noext";
                document.getElementsByTagName("head")[0].appendChild(tag);
                var trackurl = 'https://www.youtube.com/embed/{{ $youtubeurl }}';

                $('<iframe width="100%" height="400" id="youtube-video" enablejsapi="1" src="'+trackurl+'?enablejsapi=1&autoplay=1" frameborder="0"></iframe>').appendTo('#player');

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
                        console.log('done playing');
                        $('.runitem-'+getNO).find('a').trigger('click');
                        }
                    };

                    onYouTubePlayerReady = function (){
                        console.log('YT im ready');
                    };
                });


</script>
