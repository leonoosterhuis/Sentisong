<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('manage.global.head')


<body>

<div class="main-container">

    <!-- HEADER -->
    @include('manage.global.topnav')
    <!-- LEFT-CONTAINER -->
    <main>

    </main>

</div><!-- end main-container -->
</body>
</html>

<script>
    $(document).ready(function() {
        getView("dashboard")
    });

    function getView(view) {
        $("main").html("")
        var url = "{{ route('manage.getView', ":view") }}";
        url = url.replace(':view', view);
        $.get(url, function(data, status){
            $("main").html(data)
        });
    }
</script>
