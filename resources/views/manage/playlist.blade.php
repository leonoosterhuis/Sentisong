<div class="row">
    <div class="col-12">
        <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
            <h2 class="titular"><strong>My SentiSong Playlists</strong></h2>
            <table id="sentiSongTable" class="playListTable hover">
                <thead>
                <tr>
                    <th>PlayList</th>
                    <th>Tracks</th>
                    <th>Action</th>
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
            <h2 class="titular"><strong>My Spotify Playlists</strong></h2>
            <table id="spotify_table" class="playListTable hover">
                <thead>
                <tr>
                    <th>PlayList</th>
                    <th>Tracks</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>



        function init_tables() {

            var url1 = "{{ route('manage.getplaylists', ":type") }}";
            url1 = url1.replace(':type', "sentisong");
            $('#sentiSongTable').DataTable({
                // "scrollY":false,
                'processing': true,
                pageLength: 5,
                "ajax": {url: url1, type: 'GET',},
                responsive: true,
            });

            var url2 = "{{ route('manage.getplaylists', ":type") }}";
            url2 = url2.replace(':type', "spotify");
            $('#spotify_table').DataTable({
                // "scrollY":false,
                'processing': true,
                pageLength: 5,
                "ajax": {url: url2, type: 'GET',},
                responsive: true,
            });

        }


</script>

<script>

    var playListId = "";

    $(document).ready(function () {
        init_tables();
    });

    function generatePlayList(playlistID) {
        getView("gen_playlist");
        playListId = playlistID;
    }

    function editPlayList(playlistID){

    }
</script>



