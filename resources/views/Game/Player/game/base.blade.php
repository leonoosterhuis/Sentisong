<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('manage.global.head')


<body>
<br>
<br>
<div class="main-container">

    <!-- HEADER -->
    <!-- LEFT-CONTAINER -->
    <main>

    </main>

</div><!-- end main-container -->
</body>
</html>

<script>
    var gamePinCode = "{{$gamepin}}"

    $(document).ready(function() {
        getView("Player.game.game_player")
    });

    function getView(view) {
        $("main").html("")
        var url = "{{ route('game.getView', ":view") }}";
        url = url.replace(':view', view);
        $.get(url, function(data, status){
            $("main").html(data)
        });
    }
</script>

@vite(["resources/js/echo.js"])

<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
