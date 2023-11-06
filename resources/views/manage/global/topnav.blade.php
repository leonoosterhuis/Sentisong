<header id="myHeader" class="block">
    <ul class="header-menu horizontal-list">
        <li>
            <a role="button" class="header-menu-tab" onclick="getView('dashboard')" id="viewDashboard" ><span class="icon entypo-cog scnd-font-color"></span>Dashboard</a>
        </li>
        <li id="playListMenu" class="d-none">
            <a role="button" class="header-menu-tab" id="viewPlaylist" onclick="getView('playlist')"><span class="icon fontawesome-user scnd-font-color"></span>Playlist</a>
            <a role="button" class="header-menu-number" href="#4">5</a>

        </li>
    </ul>
</header>

<script>
    // When the user scrolls the page, execute myFunction
    window.onscroll = function() {stickyHeader()};

    // Get the header
    var header = document.getElementById("myHeader");

    // Get the offset position of the navbar
    var sticky = header.offsetTop;

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function stickyHeader() {
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    }
</script>
