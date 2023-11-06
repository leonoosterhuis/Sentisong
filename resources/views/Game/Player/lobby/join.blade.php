<div class="row">
    <div class="col-12">
        <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
            <h2 class="titular">Join Game</h2>
            <br><br>
            <div class="next-days">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-7 col-sm-12 col-md-12 col-xl-4 center-block">
                            <div class="input-container">
                                <input type="text" id="gamePin" placeholder="GamePin"
                                       class="email text-input text-white full-width">

                                <div class="input-icon envelope-icon-newsletter"><i
                                        class="fa-solid text-white fa-lock"></i>
                                </div>
                                <input type="text" id="playerName" placeholder="Player name"
                                       class="email text-input text-white full-width">

                                <div class="input-icon2 envelope-icon-newsletter"><i
                                        class="fa-solid text-white fa-user"></i>
                                </div>
                                <h3 class="text-white" id="message"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-sm-12 col-md-12 col-xl-3 center-block">
                            <div class="input-container">
                                <button type="button" onclick="joinSession()" class="btn btn-lg btn-success full-width">Join!</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var gamePin;
    var playerName;

   function joinSession(){

       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });

       gamePin = $('#gamePin').val();
       playerName = $('#playerName').val();


       var result = JSON.stringify([gamePin, playerName]);

       $.ajax({
           url: "{{route("game.join.post")}}",
           type: 'POST',
           data: result,
           success: function (response) {
               var status = JSON.parse(response).status;
               if (status === "success") {
                   window.location.href = "{{route("game.lobby.player")}}";
               } else {
                   alert("No connection");
               }
           },
           error: function (response) {
           }
       });
   }
</script>
