<div class="row">
    <div class="col-12">
        <div class="weather block clear"> <!-- WEATHER (MIDDLE-CONTAINER) -->
            <h2 class="titular">Lobby</h2>
            <br><br>
            <div class="next-days">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <h1 onclick="copyGamePin()" class="clickable"><span id="gamepin"></span></h1>
                            <a href="{{route("game.ingame.host")}}">
                                <button type="button" class="btn btn-success">Start Game</button>
                            </a>
                        </div>
                        <div class="col-6">
                            <div id="players"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var userIDS = [];

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $('#gamepin').text("Gamepin: " + gamePin);

        Pusher.logToConsole = true;
        window.Echo.channel('game.' + gamePin)
            .listen('GameJoin', function (e) {
                newUser(e);
            });

    });

    function newUser(user) {
        console.log(user);
        userIDS.push(user.playerID);
        var button = "<button type='button' class='btn btn-primary'>" + user.playerName + "</button><br><br>";
        $('#players').append(button);
        $.ajax({
            url: "{{route("game.add.player")}}",
            type: 'POST',
            data: JSON.stringify(userIDS),
        });

    }


    function copyGamePin() {
        const element = document.querySelector('#gamepin');
        const storage = document.createElement('textarea');
        storage.value = element.innerHTML.substring(9);
        element.appendChild(storage);
        // Copy the text in the fake `textarea` and remove the `textarea`
        storage.select();
        storage.setSelectionRange(0, 99999);
        document.execCommand('copy');
        element.removeChild(storage);
    }
</script>
