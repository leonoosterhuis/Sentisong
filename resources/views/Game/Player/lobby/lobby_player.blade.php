<div class="row">
    <div class="col-12">
        <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
            <h2 class="titular">Join Game</h2>
            <br><br>
            <div class="next-days">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-container">
                                <h1>Wait for gamestart</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function () {
        startBroadCast();
    });

    {{--function startBroadCast() {--}}
    {{--    Pusher.logToConsole = true;--}}
    {{--    window.Echo.channel('game.' + gamePin)--}}
    {{--        .listen('GameStart', (e) => {--}}
    {{--            storeSpotifyToken(e.spotifyToken, e.refreshToken)--}}
    {{--            console.log(e);--}}
    {{--            console.log("Game Start!");--}}
    {{--            window.location.href = "{{route("game.ingame.player")}}";--}}
    {{--        });--}}
    {{--}--}}

    function startBroadCast(){
        Pusher.logToConsole = true;
        window.Echo.channel('game.' + gamePin)
        .listen("GameStart", (e) => {
            storeSpotifyToken(e.spotifyToken, e.refreshToken)
                console.log(e);
                console.log("Game Start!");
                window.location.href = "{{route("game.ingame.player")}}";
        });
    }

    function storeSpotifyToken(token, refresh) {


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            url: "{{route("game.store")}}",
            type: 'POST',
            data: JSON.stringify([token, refresh]),
            success: function (response) {
                var status = JSON.parse(response).status;
                if (status === "success") {
                    console.log("Token success saved")
                } else {
                    alert("No connection");
                }
            },
            error: function (response) {
            }
        });
    }


</script>

