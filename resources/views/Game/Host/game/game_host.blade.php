<div class="row">
    <div class="col-lg-5 col-sm-12 col-md-12">
        <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
            <h2 class="titular"><strong>Song List</strong></h2>
            <table id="MusicTable" class="playListTable hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Naam</th>
                    <th>Play</th>
                    <th>Que point</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-7 col-sm-12 col-md-12">
        <div class="row">
            <div id="musicControls" class="col-12">
                <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
                    <h2 class="titular"><strong>Music Controls</strong></h2>

                    <div class="spotify-info text-white">
                        <br>
                        <h4 id="currentPlayingText"></h4>
                        <div class="row">
                            <br>
                            <hr>
                            <h5 id="Track">Loading...</h5>
                            <h5 id="Artist"></h5>
                            <h5 id="Album"></h5>
                            <h5 id="Year"></h5>
                            <hr>
                            <h5 id="Device"></h5>
                        </div>


                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <button type="button" class="btn btn-warning full-width spaceButton">Pause</button>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <button type="button" class="btn btn-primary full-width spaceButton">Que point
                                </button>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <button id="endRoundButton" type="button" onclick="hitEnd()"
                                        class="btn btn-danger full-width spaceButton d-none">
                                    End round
                                </button>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>

            </div>


            <div class="col-12">
                <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
                    <h2 class="titular"><strong>Player List</strong></h2>
                    <table id="UserTable" class="playListTable hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Naam</th>
                            <th>Score</th>
                            <th class="">user_id</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <button type="button" onclick="stopGame()" class="btn btn-danger full-width">Stop Game!</button>
            </div>
        </div>
    </div>
</div>

<script>
    var MusicTable;
    var UserTable;

    var expectedUsers = [];
    var activeUsers = [];

    var playerResults = {};
    var scoreBoard = {};

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        startBroadCast()
        load_spotify_data()
        sendReadyMessageToPlayers()
        fillSongTable();
        showUserTable();
        $("#gamepin").text(gamePinCode)
        $("#players").text(activeUsers.length + "/" + expectedUsers.length);
    });


    function showUserTable() {
        UserTable = $('#UserTable').DataTable({
            // "scrollY":false,
            'processing': true,
            pageLength: 8,
            responsive: true,
            "dom": 'rtip',
            searching: false,
            ordering: false,
            "language": {
                "emptyTable": "No scores found!"
            },
            order: [[0, 'desc']],
            columnDefs: [
                {
                    target: 3,
                    visible: false,
                    searchable: false,
                },
            ],
        });
        updateTable();
    }


    function sendReadyMessageToPlayers() {
        $.get("{{route("game.ready")}}", function (data, status) {
            expectedUsers = JSON.parse(data);
        });
    }

    function startBroadCast() {
        Pusher.logToConsole = true;
        window.Echo.channel('game.' + gamePinCode)
            .listen('GameReady', (e) => { //Speler meld zich succesvol aan na gamestart
                playerHeartBeat(e);
            })
            .listen('GameNewRound', (e) => { //Song loaded
                updateHostScreen(e)
            });
    }

    function hitPause() {

    }


    function load_spotify_data() {
        $.get("{{route("manage.spotify.getData")}}", function (data, status) {
            var result = JSON.parse(data);
            if (result.CurrentlyPlayingTrack !== null) {
                $("#Track").text("Track: " + result.CurrentlyPlayingTrack.item.name);
                $("#Artist").text("Artist: " + result.CurrentlyPlayingTrack.item.artists[0].name);
                $("#Album").text("Album: " + result.CurrentlyPlayingTrack.item.album.name);
                $("#Year").text("Year: " + result.CurrentlyPlayingTrack.item.album.release_date.substring(0, 4));
                $("#currentPlayingText").text("Currently Playing:");


            } else {
                $("#Track").text("It's very quiet on your spotify");
                $("#Track").addClass("text-center");
            }
        });
    }

    function hitEnd() {
        $("#endRoundButton").addClass("d-none");
        $.get("{{route("game.control.endRound")}}", function (data, status) {
            console.log("hit end");
            updateTable();
        });
    }

    function updateTable() {
        $.get("{{route("game.allplayerresult")}}", function (data, status) {
            var json = JSON.parse(data);
            UserTable.clear().draw();
            $.each(json.ranking, function (index, item) {
                UserTable.row.add([item.ranking, item.player_name, item.score, item.player_id]).draw(false);
            });
        });
    }

    function hitStartPoint() {

    }

    function playerHeartBeat(user) {
        if (jQuery.inArray(user.playerID, activeUsers) === -1) {
            activeUsers.push(user.playerID);
            playerResults[user.playerID] = {};
            scoreBoard[user.playerID] = 0;
            // addUserToTable(user)
        }

        $("#players").text(activeUsers.length + "/" + expectedUsers.length);
    }

    function addUserToTable(user) {
        UserTable.row.add([user.playerName, 0, user.playerID]).draw(false);
    }

    function addScore(playerID, round, score) {

        var oldResult = playerResults[playerID];
        oldResult[round] = score;
        playerResults[playerID] = oldResult

        var oldscore = scoreBoard[playerID];
        oldscore += score;
        scoreBoard[playerID] = oldscore
    }


    function stopGame() {
        $.get("{{route("game.stop")}}", function (data, status) {
        });
    }

    function fillSongTable() {

        $.get("{{route("game.info")}}", function (data, status) {
            MusicTable = $('#MusicTable').DataTable({
                // "scrollY":false,
                'processing': true,
                pageLength: 8,
                responsive: true,
                // "dom": 'rtip',
                searching: false,
                "language": {
                    "emptyTable": "Loading songs..."
                }
            });

            var json = JSON.parse(data);
            var playlist = JSON.stringify(json[1].ActiveSongs);

            $.ajax({
                url: "{{route("game.info.track")}}",
                type: 'POST',
                data: playlist,
                success: function (response) {
                    fillTable(JSON.parse(response))
                },
                error: function (response) {
                }
            });

        });


        function fillTable(data = undefined) {
            $.each(data, function (index, item) {
                var minutes = item[2].toString();
                var seconds = item[3].toString();
                if (seconds.length === 1) {
                    if (!seconds.startsWith("0")) {
                        seconds = "0" + seconds;
                    }
                    else{
                        seconds += "0";
                    }
                }
                console.log(item)
                var playString = "<button type='button' class='btn btn-success' onclick='pressedPlay(`" + item[1] + "`, `" + item[2] +"`,`" + item[3] +"`)'>Play</button>"
                var quepointString = minutes + ":" + seconds;
                MusicTable.row.add([index + 1, item[0], playString, quepointString]).draw(false);
            });
        }

    }

    function pressedPlay(item = undefined, minute = 0, second = 0) {
        console.log(item);
        var postData = JSON.stringify([gamePinCode, item, minute, second]);
        console.log(postData);

        $.ajax({
            url: "{{route("game.control.playRound")}}",
            type: 'PUT',
            data: postData,
            success: function (response) {
                var json = JSON.parse(response);
                if (json.status == null) {
                    console.log("success");
                } else if (json.status.hasOwnProperty("error")) {
                    if (json.status.error.status === 403) {
                        alert("Sentisong can't control this device, please try connecting with bluetooth and try again")
                    } else {
                        alert("Error");
                    }
                } else {
                    alert("Errors");
                }
            },
            error: function (response) {
                alert("Can't reach gameserver");
            }
        });
    }

    function updateHostScreen(e) {
        load_spotify_data();
        $("#endRoundButton").removeClass("d-none");

    }


</script>

