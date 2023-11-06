<div class="container-fluid">
    {{--    Good Luck Message--}}
    <div class="row">
        <div class="col-12">
            <div id="goodLuckMessage" class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
                <h2 class="titular"><strong>Good Luck!</strong></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div id="songListBlock" class="weather block clear d-none"> <!-- WEATHER (MIDDLE-CONTAINER) -->
                <h2 class="titular"><strong>Song List</strong></h2>
                <div class="container-fluid">
                    <div class="row full-height-div">
                        <div class="col-lg-2 col-xl-2"></div>
                        <div class="col-md-6 col-sm-6 col-lg-2 col-xl-2 col-6 card-center">
                            <div class="song-cards-list" onclick="clickFillTrack()">
                                <div class="card 1">
                                    <div class="card_image"><img src="https://i.redd.it/b3esnz5ra34y.jpg"/></div>
                                    <div class="card_title title-white">
                                        <span>Track</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-2 col-xl-2 col-6 card-center">
                            <span id="trackBadgeSuccess" class="badge badge-success badge-mobile d-none">Success</span>
                            <span id="trackBadgeNot" class="badge badge-mobile badge-danger">Not yet completed</span>
                        </div>
                        <div class="col-lg-2 col-xl-2"></div>
                    </div>
                    <div class="row full-height-div">
                        <div class="col-lg-2 col-xl-2"></div>
                        <div class="col-md-6 col-sm-6 col-lg-2 col-xl-2 col-6 card-center">
                            <div class="song-cards-list" onclick="clickFillArtist()">
                                <div class="card 1">
                                    <div class="card_image"><img src="https://i.redd.it/b3esnz5ra34y.jpg"/></div>
                                    <div class="card_title title-white">
                                        <span>Artist</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-2 col-xl-2 col-6 card-center">
                            <span id="artistBadgeSuccess" class="badge badge-mobile badge-success d-none">Success</span>
                            <span id="artistBadgeNot" class="badge badge-mobile badge-danger">Not yet completed</span>
                        </div>
                        <div class="col-lg-2 col-xl-2"></div>
                    </div>
                    <div class="row full-height-div">
                        <div class="col-lg-2 col-xl-2"></div>
                        <div class="col-md-6 col-sm-6 col-lg-2 col-xl-2 col-6 card-center">
                            <div class="song-cards-list" onclick="clickFillYear()">
                                <div class="card 1">
                                    <div class="card_image"><img src="https://i.redd.it/b3esnz5ra34y.jpg"/></div>
                                    <div class="card_title title-white">
                                        <span>Year</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-lg-2 col-xl-2 col-6 card-center">
                            <span id="yearBadgeSuccess" class="badge badge-mobile badge-success d-none">Success</span>
                            <span id="yearBadgeNot" class="badge badge-mobile badge-danger">Not yet completed</span>
                        </div>
                        <div class="col-lg-2 col-xl-2"></div>
                    </div>
                </div>
            </div>
            <div id="seachBlock" class="row d-none">
                <div class="col-xl-2 col-lg-2"></div>
                <div class="col-xl-8 col-lg-8 col-12">
                    <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
                        <h2 class="titular"><strong>Search</strong></h2>
                        <br>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-container full-width">
                                            <input id="searchInput" type="text" placeholder="Search..."
                                                   class="email text-input center-horizon">
                                            <div class="input-icon envelope-icon-newsletter"><i
                                                    class="fa-solid text-white fa-guitar"></i></div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" id="saveButton" onclick="onClickSave()"
                                            class="btn btn-success center-horizon btnSizeSongSearch d-none spaceButton">
                                        Save!
                                    </button>
                                </div>
                                <div class="row bottom-buffer-1">
                                    <div class="col-6">
                                        <button type="button" onclick="searchResult()"
                                                class="btn btn-primary center-horizon btnSizeSongSearch">Search!
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" onclick="onClickCancel()"
                                                class="btn btn-danger center-horizon btnSizeSongSearch">Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2"></div>

            </div>
            <div id="resultBlock" class="row d-none">
                <div class="col-xl-2 col-lg-2"></div>
                <div class="col-xl-8 col-lg-8 col-12">
                    <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <br>
                                    <div class="input-group">
                                        <div class="input-container full-width center-horizon">
                                            <div id="searchResultsDiv" class="row">
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2"></div>
            </div>
            <div id="YearPicker" class="d-none">
                <div class="row">
                    <div class="col-xl-2 col-lg-1"></div>
                    <div class="col-xl-8 col-lg-10 col-12">
                        <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
                            <h2 class="titular"><strong>Year</strong></h2>
                            <br>
                            <div class="container-fluid">
                                <h2 class="titular" id="YearError"></h2>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mx-auto justify-content-center">
                                            <h3 class="text-white">Exact year</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mx-auto justify-content-center">
                                            <br>
                                            <br>
                                            <input id="number1" class="number yearNumber" maxlength="1" size="1"/>
                                            <input id="number2" class="number yearNumber" maxlength="1" size="1"/>
                                            <input id="number3" class="number yearNumber" maxlength="1" size="1"/>
                                            <input id="number4" class="number yearNumber" maxlength="1" size="1"/>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mx-auto justify-content-center">
                                            <h3 class="text-white">Year range</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="input-group mx-auto justify-content-center">
                                            <input id="number5" class="number yearNumber" maxlength="1" size="1"/>
                                            <input id="number6" class="number yearNumber" maxlength="1" size="1"/>
                                            <input id="number7" class="number yearNumber" maxlength="1" size="1"/>
                                            <input id="number8" class="number yearNumber" maxlength="1" size="1"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="input-group mx-auto justify-content-center">
                                            <input id="number9" class="number yearNumber" maxlength="1" size="1"/>
                                            <input id="number10" class="number yearNumber" maxlength="1" size="1"/>
                                            <input id="number11" class="number yearNumber" maxlength="1" size="1"/>
                                            <input id="number12" class="number yearNumber" maxlength="1" size="1"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <br><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-1"></div>
                </div>
                <div class="row">
                    <div class="col-xl-2 col-lg-1"></div>
                    <div class="col-xl-8 col-lg-10 col-12">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" id="saveButtonYear" onclick="onClickSave()"
                                        class="btn btn-success center-horizon btnSizeSongSearch">Save!
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" onclick="onClickCancel()"
                                        class="btn btn-danger center-horizon btnSizeSongSearch">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-1"></div>
                </div>
            </div>
        </div>
    </div>


    {{-- Round Results--}}
    <div class="row">
        <div class="col-12">
            <div id="roundResult" class="weather block clear d-none"> <!-- WEATHER (MIDDLE-CONTAINER) -->
                <h2 class="titular"><strong>Results</strong></h2>
                <br><br>
                <div class="container-fluid">
                    <div class="row bottom-buffer-1">
                        <div class="col-lg-2 col-xl-2"></div>
                        <div class="col-md-6 col-xl-4 col-lg-4 col-sm-12 bottom-buffer-2">
                            <img id="tumbnailIMG" class="center-block spotify_album_cover"
                                 src="https://i.redd.it/b3esnz5ra34y.jpg"/>
                        </div>
                        <div class="col-md-6 col-xl-4 col-lg-4 col-sm-12 center-block text-center text-white">
                            <h3>Track: <span id="trackField">Unknown</span></h3>
                            <h3>Artist: <span id="artistField">Unknown</span></h3>
                            <h3>Year: <span id="yearField">Unknown</span></h3>
                        </div>
                        <div class="col-lg-2 col-xl-2"></div>
                    </div>
                    <hr class="hr-styling">
                    <div class="row">
                        <div class="col-12 text-center text-white bottom-buffer-1">
                            <h3>Scores</h3>
                        </div>
                    </div>
                    <div class="row bottom-buffer-3">
                        <div class="col-6 text-white text-center">
                            <h3>Track: +<span id="scoreTrack">0</span></h3>
                            <h3>Artist: + <span id="scoreArtist">0</span></h3>
                            <h3>Year: +<span id="scoreYear">0</span></h3>
                        </div>
                        <div class="col-6 text-white text-center">
                            <h3>Total Score: <span id="totalScorePlayer">Unknown</span></h3>
                            <h3>Ranking: <span id="rankingPlayer">Unknown</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var trackFilled = "";
    var artistFilled = "";
    var yearFilled = "";

    var correctTrack = "";
    var correctArtist = "";
    var correctYear = "";
    var tumbnailURL = "";

    var scoreTrack = 0;
    var scoreArtist = 0;
    var scoreYear = 0;

    var resultFilling = "";

    $(document).ready(function () {

        var input = document.getElementById("searchInput");
        input.addEventListener("keypress", function (event) {
            // If the user presses the "Enter" key on the keyboard
            if (event.key === "Enter") {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                searchResult();
            }
        });

        $('.number').autotab('number');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        startBroadCast()
    });

    function startBroadCast() {
        Pusher.logToConsole = true;
        window.Echo.channel('game.' + gamePinCode)
            .listen('GameNewRound', (e) => { //Speler luistert naar nieuwe ronde
                newRound(e);
            })
            .listen('GameEndRound', (e) => { //Speler luistert naar Einde van huidige ronde
                endRound();
            })
            .listen('GameEnd', (e) => { //Speler luistert naar Einde van huidige ronde
                endGame();
            });


    }

    function getPlayerResult() {
        $.get("{{ route('game.playerresult') }}", function (data, status) {
            var json = JSON.parse(data);
            $("#totalScorePlayer").text(json.score)
            $("#rankingPlayer").text(json.ranking + "/" + json.rankingOff)
        });
    }

    function endGame() {
        window.location.href = "{{route("game.join")}}";
    }

    function newRound(e) {
        $("#goodLuckMessage").addClass("d-none");
        $("#songListBlock").removeClass("d-none");
        $("#roundResult").addClass("d-none");

        correctTrack = e.roundFillForm.correctTrack;
        correctArtist = e.roundFillForm.correctArtist;
        correctYear = e.roundFillForm.correctYear;
        tumbnailURL = e.roundFillForm.tumbnail

        trackFilled = "";
        artistFilled = "";
        yearFilled = "";
        $(".number").val("");


        $("#trackBadgeNot").removeClass("d-none");
        $("#trackBadgeSuccess").addClass("d-none")
        $("#artistBadgeNot").removeClass("d-none");
        $("#artistBadgeSuccess").addClass("d-none");
        $("#yearBadgeNot").removeClass("d-none");
        $("#yearBadgeSuccess").addClass("d-none");
    }

    function endRound() {
        $("#trackField").text(correctTrack);
        $("#artistField").text(correctArtist);
        $("#yearField").text(correctYear);


        $("#scoreTrack").text(scoreTrack);
        $("#scoreArtist").text(scoreArtist);
        $("#scoreYear").text(scoreYear);
        $("#tumbnailIMG").attr("src", tumbnailURL);

        $("#songListBlock").addClass("d-none");
        $("#roundResult").removeClass("d-none");
        getPlayerResult();
    }


    function searchResult() {
        var searchField = $("#searchInput").val().replace(/ /g, "%20");
        var postData = JSON.stringify([resultFilling, searchField]);

        $.ajax({
            url: "{{route("game.search")}}",
            type: 'POST',
            data: postData,
            success: function (response) {
                var json = JSON.parse(response);
                showSearchResults(json);
            },
            error: function (response) {
                alert("Can't reach gameserver");
            }
        });
    }

    function showSearchResults(results) {
        $("#resultBlock").removeClass("d-none");
        $("#searchResultsDiv").html("");
        if (resultFilling === "track") {
            var searcharray = results[0].tracks.items;
        }
        if (resultFilling === "artist") {
            var searcharray = results[0].artists.items;
        }

        $.each(searcharray, function (index, item) {
            var playString = '<div class="col"><span class="musicSearchBadge badge">' + item.name + '</span></div>';
            $("#searchResultsDiv").append(playString);
        });
    }

    $("#searchResultsDiv").on("click", "span.musicSearchBadge", function () {

        $(".musicSearchBadge").removeClass("choosen_badge")
        $(this).addClass("choosen_badge");
        $("#saveButton").removeClass("d-none");
        if (resultFilling === "track") {
            trackFilled = $(this)[0].textContent;
        }
        if (resultFilling === "artist") {
            artistFilled = $(this)[0].textContent;
        }
    });

    function onClickCancel() {
        $("#seachBlock").addClass("d-none");
        $("#resultBlock").addClass("d-none");
        $("#YearPicker").addClass("d-none");
        $("#songListBlock").removeClass("d-none");
        if (resultFilling === "track") {
            trackFilled = "";
        }
        if (resultFilling === "artist") {
            artistFilled = "";
        }
    }

    function onClickSave() {
        if (resultFilling === "track") {
            $("#trackBadgeNot").addClass("d-none");
            $("#trackBadgeSuccess").removeClass("d-none")
        }
        if (resultFilling === "artist") {
            $("#artistBadgeNot").addClass("d-none");
            $("#artistBadgeSuccess").removeClass("d-none")
        }
        if (resultFilling === "year") {
            if (saveYear()) {
                $("#yearBadgeNot").addClass("d-none");
                $("#yearBadgeSuccess").removeClass("d-none")
            } else {
                $("#YearError").text("No Valid year!");
                return;
            }
        }
        $("#seachBlock").addClass("d-none");
        $("#resultBlock").addClass("d-none");
        $("#YearPicker").addClass("d-none");
        $("#saveButton").addClass("d-none");
        $("#songListBlock").removeClass("d-none");
        sendScore();

    }

    function saveYear() {
        if (checkDefined("number1") && checkDefined("number2") && checkDefined("number3") && checkDefined("number4")) {
            yearFilled = $("#number1").val() + $("#number2").val() + $("#number3").val() + $("#number4").val();
            return true;
        }
        if (checkDefined("number5") && checkDefined("number6") && checkDefined("number7") && checkDefined("number8")
            && checkDefined("number9") && checkDefined("number10") && checkDefined("number11") && checkDefined("number12")) {
            yearFilled = $("#number5").val() + $("#number6").val() + $("#number7").val() + $("#number8").val() + "-"
                + $("#number9").val() + $("#number10").val() + $("#number11").val() + $("#number12").val()
            return true;
        }
        return false;


        function checkDefined(e) {
            var selector = "#" + e
            return !($(selector).val() === "" || $(selector).val() == null);
        }
    }

    function clickFillTrack() {
        resultFilling = "track";
        if (trackFilled === "") {
            goFillResult();
        }
    }

    function clickFillArtist() {
        resultFilling = "artist";
        if (artistFilled === "") {
            goFillResult();
        }
    }

    function clickFillYear() {
        resultFilling = "year";
        if (yearFilled === "") {
            goFillResult_year();
        }
    }

    function goFillResult() {
        $("#searchInput").val("");
        $("#searchResultsDiv").html("");
        $("#songListBlock").addClass("d-none");
        $("#seachBlock").removeClass("d-none");
    }

    function goFillResult_year() {
        $("#songListBlock").addClass("d-none");
        $("#YearPicker").removeClass("d-none");
    }

    function sendScore() {
        var score = 0;
        if (resultFilling === "track") {
            score = calculateTrackScore();
            console.log("track", score);
        }
        if (resultFilling === "artist") {
            score = calculateArtistScore();
            console.log("artist", score);
        }
        if (resultFilling === "year") {
            score = calculateYearScore();
            console.log("year", score);
        }

        $.ajax({
            url: "{{route("game.result")}}",
            type: 'POST',
            data: JSON.stringify([score]),
            success: function (response) {
                var json = JSON.parse(response);
                console.log(json);
            },
            error: function (response) {
                alert("Can't reach gameserver");
            }
        });


        function calculateTrackScore() {
            if (correctTrack === trackFilled) {
                scoreTrack = 5;
                return 5;
            } else {
                scoreTrack = 0;
                return 0;
            }
        }

        function calculateArtistScore() {
            if (correctArtist === artistFilled) {
                scoreArtist = 5;
                return 5;
            } else {
                scoreArtist = 0;
                return 0;
            }
        }

        function calculateYearScore() {
            if (yearFilled.length === 4) {
                if (parseInt(yearFilled) === parseInt(correctYear)) {
                    scoreYear = 10;
                    return 10;
                }
            }
            if (yearFilled.length === 9) {
                var fromYear = parseInt(yearFilled.substring(0, 4));
                var toYear = parseInt(yearFilled.substring(5, 9));
                if ((fromYear <= correctYear) && (correctYear <= toYear)) {//TODO FIX!
                    var difference = toYear - fromYear;
                    var score = Math.ceil(difference / 2)
                    var total = 10 - score;
                    if (total > 0) {
                        scoreYear = total;
                        return total
                    } else {
                        scoreYear = 0;
                        return 0;
                    }
                } else {
                    scoreYear = 0;
                    return 0
                }

            }
            scoreYear = 0;
            return 0;
        }

    }


</script>
