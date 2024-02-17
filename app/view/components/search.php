<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../view/components/search.css">
    <script src="../view/components/search.js"></script>
</head>
<body>

<div class="search-content">
    <div class="rounded-box">
        <h1 style="color: #739ad1; font-weight: bold;">Search</h1>
        <form id="searchForm" onsubmit="performSearch(); return false;">
            <input type="text" id="searchInput" placeholder="Enter Username Here">
            <button type="button" onclick="performSearch()">Search</button>
        </form>
        
        <div id="searchResult"></div>
    </div>
</div>

</body>
</html>
