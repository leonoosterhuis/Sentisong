<div class="row">
    <div class="col-12">
        <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
            <h2 class="titular"><strong>Current Playlist</strong></h2>
            <br><br>
            <div class="row" style="--bs-gutter-x: 0">
                <div class="col-6">
                    <div class="input-container">
                        <input type="text" id="playListName" placeholder="Playlist name"
                               class="email text-input text-white">
                        <div class="input-icon envelope-icon-newsletter"><i class="fa-solid fa-music text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <button type="button" onclick="savePlayList()" class="btn btn-success savePlaylist">Make!</button>
                </div>
            </div>
            <hr>
            <table id="currentPlaylist" class="playListTable hover">
                <thead>
                <tr>
                    <th>Add</th>
                    <th>Name</th>
                    <th>Artist</th>
                    <th>Album</th>
                    <th>Length</th>
                    <th>Start</th>
                    <th class="">songid</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
            <h2 class="titular"><strong>Spotify playlist</strong></h2>
            <br><br>
            <table id="generateTable" class="playListTable hover">
                <thead>
                <tr>
                    <th>Add</th>
                    <th>Name</th>
                    <th>Artist</th>
                    <th>Album</th>
                    <th>Length</th>
                    <th>Start</th>
                    <th class="">songid</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

    var spotifyTableGlob;
    var currentPlayList;

    $(document).ready(function () {
        loadPlayList()
        initCurrentTable()
    });

    //Add
    $('#generateTable tbody').on('click', '.addbtn', function (e) {
        e.preventDefault();
        var row = spotifyTableGlob.row($(this).parents('tr'));
        var rowNode = row.data();
        var minuteValue = $("#idm-" + rowNode[6]).val();
        var SecondsValue = $("#ids-" + rowNode[6]).val();
        rowNode[0] = "<button type='button'class='btn btn-danger addbtn'>Remove</button>";
        currentPlayList.row.add(rowNode).draw();
        $("#idm-" + rowNode[6]).val(minuteValue);
        $("#ids-" + rowNode[6]).val(SecondsValue);
        row.remove().draw()

    });


    //Remove
    $('#currentPlaylist tbody').on('click', '.addbtn', function (e) {
        e.preventDefault();
        var row = currentPlayList.row($(this).parents('tr'));
        var rowNode = row.data();
        var minuteValue = $("#idm-" + rowNode[6]).val();
        var SecondsValue = $("#ids-" + rowNode[6]).val();
        rowNode[0] = "<button type='button'class='btn btn-success addbtn'>Add</button>";
        spotifyTableGlob.row.add(rowNode).draw();
        $("#idm-" + rowNode[6]).val(minuteValue);
        $("#ids-" + rowNode[6]).val(SecondsValue);
        row.remove().draw()
    });

    function initCurrentTable() {
        currentPlayList = $('#currentPlaylist').DataTable({
            'processing': true,
            pageLength: 20,
            columnDefs: [
                {
                    target: 6,
                    visible: false,
                    searchable: false,
                },
            ],
        });
    }


    function savePlayList() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var playlistName = $("#playListName").val();
        var ResultsCurrent = currentPlayList.rows().data().toArray();
        console.log(ResultsCurrent);


        $.each(ResultsCurrent, function (index, item) {
            console.log(index,item);
            var minuteValue = $("#idm-" + item[6]).val();
            var SecondsValue = $("#ids-" + item[6]).val();
            console.log(minuteValue, SecondsValue);
            ResultsCurrent[index][7] = minuteValue;
            ResultsCurrent[index][8] = SecondsValue;
        });



        console.log(ResultsCurrent);
        var result = JSON.stringify([playlistName, ResultsCurrent]);

        $.ajax({
            url: "{{route("manage.saveplaylist")}}",
            type: 'POST',
            data: result,
            success: function (response) {
                // console.log(response);
            },
            error: function (response) {
                // console.log("error" + response);
            }
        });

        getView("playlist")

    }

    function loadPlayList() {
        // console.log(playListId);
        var url4 = "{{ route('manage.getplaylist', ":playlist") }}";
        url4 = url4.replace(':playlist', playListId);
        spotifyTableGlob = $('#generateTable').DataTable({
            // "scrollY":false,
            'processing': true,
            pageLength: 20,

            "ajax": {url: url4, type: 'GET',},
            responsive: true,
            columnDefs: [
                {
                    target: 6,
                    visible: false,
                    searchable: false,
                },
            ],
        });
    }
</script>




