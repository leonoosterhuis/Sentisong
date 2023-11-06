<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('manage.global.head')


<body>

<div class="main-container">

    <!-- HEADER -->
    @include('Game.Host.game.topnav')
    <!-- LEFT-CONTAINER -->
    <main>

    </main>

</div><!-- end main-container -->
</body>
</html>

<script>

    var gamePinCode = "{{$gamepin}}"

    $(document).ready(function() {
        getView("Host.game.game_host")
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

