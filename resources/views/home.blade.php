
<!-- Canvas -->
<canvas class="orb-canvas"></canvas>
<!-- Overlay -->
<div class="overlay">
    <!-- Overlay inner wrapper -->
    <div class="overlay__inner">
        <div class="container text-center">
        <div class="row">
        <!-- Title -->
        <h1 class="overlay__title">
            SentiSong
        </h1>
        <!-- Description -->
        <p class="overlay__description">
            {{ $randomQuote }}
        </p>
        </div>


{{--            <x-nav-link :href="route('/manage')" :active="request()->routeIs('/manage')">--}}
{{--                {{ __('Dashboard') }}--}}
{{--            </x-nav-link>--}}

            <div class="row">
                <div class="col-6">
                    <a href="{{route('game.join')}}" class="btn btn-3 {{\App\Helpers\activeMenu('manage')}}">Join Session</a>
                </div>
                <div class="col-6">
                    <a href="{{route('manage')}}" class="btn btn-1 {{\App\Helpers\activeMenu('manage')}}">Create Session</a>
                </div>
            </div>


        </div>
        <!-- Buttons -->
    </div>
</div>

