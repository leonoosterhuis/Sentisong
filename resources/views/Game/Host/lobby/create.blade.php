<div class="row">
    <div class="col-12">
        <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
            <h2 class="titular">Game settings</h2>
            <br><br>
            <div class="next-days">
                <div class="container-fluid">
                    <div class="col-lg-7 col-sm-12 col-md-12 col-xl-3">
                        <div class="row">
                            <div class="input-container">
                                <label for="GameMode" class="form-label text-white">GameMode</label>
                                <select id="gameModeSelect" class="form-select" aria-label="Default select example">
                                    <option value="1">Normal</option>
                                    <option value="1">Changing Host (not functional)</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="input-container">
                                <label for="Playlist" class="form-label text-white">Playlist</label>
                                <select id="playlistSelect" class="form-select" aria-label="Default select example">
                                    <option value="1">Loading...</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="input-container">
                                <label for="Tips" class="form-label text-white">Tips</label>
                                <select id="tipsSelect" class="form-select" aria-label="Default select example">
                                    <option value="1">None</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="input-container">
                                <button type="button" onclick="sendCreateRequest()" class="btn btn-success">Create Session</button>
                            </div>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var gamepin = "";

    function sendCreateRequest(){

        var playlistName = $( "#playlistSelect option:selected" ).text();
        var gameMode = $( "#gameModeSelect option:selected" ).text();
        var tips = $( "#tipsSelect option:selected" ).text();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var result = JSON.stringify([playlistName, gameMode, tips]);

        $.ajax({
            url: "{{route("game.create.post")}}",
            type: 'POST',
            data: result,
            success: function (response) {
                gamepin = response;
                window.location.href = "{{route("game.lobby.host")}}";
                // getView("Host.lobby.lobby_host")
            },
            error: function (response) {
                alert("Something went wrong!")
            }
        });



    }

    $(document).ready(function () {
        var url = "{{ route('manage.getplaylists', ":type") }}";
        url = url.replace(':type', "sentisong");
        $.get(url, function (data, status) {
            var json = JSON.parse(data);
            if (json.data.length > 0) {
                $("#playlistSelect").empty();
                $.each(json.data, function (key, value) {
                    $("#playlistSelect").append('<option value=' + value[0] + '>' + value[0] + '</option>');
                });
            }
            else{
                $("#playlistSelect").append('<option value="-1">No PlayLists Found</option>');
            }
        });
    });



</script>
