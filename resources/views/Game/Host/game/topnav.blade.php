<header id="myHeader" class="block">
    <ul class="header-menu horizontal-list">
        <li>
            <h4 class="header-menu-tab text-white">Gamepin: <span id="gamepin"></span> </h4>

        </li>
        <li>
            <h4 class="header-menu-tab text-white">Players: <span id="players"></span> </h4>

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
