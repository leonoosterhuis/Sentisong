<div class="row">
    <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="weather block clear">
            <h2 class="titular">Game menu</h2>
            <ul class="next-days">
                <li>
                    <a href="{{route("game.join")}}">
                        <p class="next-days-date">Join Session</p>
                    </a>
                </li>
                @if(session()->has('spotify.access_token'))
                    <li>
                        <a href="{{route("game.create")}}">
                            <p class="next-days-date">Create Session</p>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div id="spotify_not_connected" class="col-sm-12 col-md-8 col-lg-8 d-none">
        <div class="calendar-day block">
            <div class="arrow-btn-container">
                <h2 class="titular">Spotify Connect</h2>
            </div>
            <br>
            <i class="d-flex justify-content-center fa-brands text-center sfyIcon text-white fa-spotify"></i>
            <br>
            <a class="add-event button" onclick="init_spotify()" href="#">Connect</a>
        </div>
    </div>


    <div id="spotify_connected" class="col-sm-12 col-md-8 col-lg-8 d-none">
        <div class="row">

            <div class="col-12">
                <div class="calendar-day block"> <!-- CALENDAR DAY (RIGHT-CONTAINER) -->
                    <div class="arrow-btn-container">
                        <h2 class="titular">Spotify Connect</h2>

                    </div>

                    <div class="spotify-info text-white">
                        <br>
                        <h3 class="text-center" id="User">loading...</h3>
                        <hr>
                        <h5 id="Track"></h5>
                        <h5 id="Artist"></h5>
                        <h5 id="Album"></h5>
                        <hr>
                        <h5 id="Device"></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
    function init_spotify() {
        $.get("{{route("manage.spotify_init")}}", function (data, status) {
            window.location.replace(data);
        });
    }

    function load_spotify_data() {
        $("#spotify_connected").removeClass("d-none");
        $("#spotify_not_connected").addClass("d-none");

        $.get("{{route("manage.spotify.getData")}}", function (data, status) {
            var result = JSON.parse(data);
            if (result.CurrentlyPlayingTrack !== null) {
                $("#Track").text("Track: " + result.CurrentlyPlayingTrack.item.name);
                $("#Artist").text("Artist: " + result.CurrentlyPlayingTrack.item.artists[0].name);
                $("#Album").text("Album: " + result.CurrentlyPlayingTrack.item.album.name);
                $("#Device").text("Plays on: " + result.AvailableDevices.devices[0].name);
            } else {
                $("#Track").text("It's very quiet on your spotify");
                $("#Track").addClass("text-center");
            }
            $("#User").text(result.CurrentUserProfile.display_name + "'s Spotify account");
        });
    }


    $(document).ready(function () {
        $("*").dblclick(function (e) {
            e.preventDefault();
        });

        $.get("{{route("manage.spotify.check")}}", function (data, status) {
            var result = JSON.parse(data);
            if (result.status === "connected") {
                load_spotify_data();
                $('#playListMenu').removeClass("d-none");
            } else {
                $('#spotify_not_connected').removeClass("d-none");
            }
        });
    });

</script>

