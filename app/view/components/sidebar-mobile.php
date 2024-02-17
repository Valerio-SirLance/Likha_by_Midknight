<script src="../view/components/notification-handler.js"></script>

<?php
// Include the profile controller to ensure that session variables are set
include('../user profile/session-handler.php');
?>
<input type="text" id="notif-badge-sidebar" 
    value="<?php echo $_SESSION['notif_badge']; ?>" hidden >
<nav class="navigation-mobile">
    <!-- HOME -->
    <a href="../home/home.php">
        <img src="../assets/images/home_icon.png" alt="Home">
        </a>
    </li>

    <!-- SEARCH -->
    <a href="#" id="search_btn">
        <img src="../assets/images/search_icon.png" alt="Search">
        Search
        <div class="search-content">
            <div class="rounded-box">
                <h2>Search</h2>
                <form id="searchForm" onsubmit="return false;">
                    <input type="text" id="searchInput" placeholder="Enter Username Here">
                    <button type="button" onclick="performSearch()">Search</button>
                </form>
                <div id="recentSearches" class="recent-searches">
                    <!-- Display recent searches or "No recent searches" -->
                </div>
                <button id="recentSearches" onclick="clearSearchHistory()">Clear Search History</button>
            </div>
        </div>
    </a>

    <!-- POST -->
    <a href="../posting/post.php">
        <img src="../assets/images/post_icon.png" alt="Post">
    </a>

    <!-- PROFILE -->
    <a href="../user profile/profile.php?username=<?php echo $mainLoggedInUsername; ?>">
        <img src="../assets/images/profile_icon.png" alt="Profile">
        Profile
    </a>

    <!-- MORE -->
    <a class="more-dropdown" href="#">
        <img src="../assets/images/more_icon.png" alt="More">
        <div class="dropdown-content">
            <a href="../settings/settings.php">
                Settings</a>
            <a href="../help/help-support.php">
                Help and Support</a>
            <a href="../login/login.php">
                Log Out</a>
        </div>
    </a>

</nav>
