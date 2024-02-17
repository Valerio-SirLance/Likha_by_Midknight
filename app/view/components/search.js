/* FOR SEARCH*/
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("search_btn").addEventListener("click", function (e) {
    console.log("Document Clicked");
    const notifContent = document.querySelector(".notification-container");

    // Close search content if it's open
    if (notifContent.classList.contains("show-notif")) {
      notifContent.classList.remove("show-notif");
    }
    e.stopPropagation();
    const searchContent = document.querySelector(".search-content");
    searchContent.classList.toggle("show-search"); // Toggle the "show-search" class
  });

  // Handle clicks outside the search content and the "Search" button
  document.addEventListener("click", function (e) {
    const searchContent = document.querySelector(".search-content");
    const searchBtn = document.getElementById("search_btn");

    if (
      searchContent &&
      searchBtn &&
      e.target.closest(".search-content") === null &&
      e.target !== searchBtn
    ) {
      searchContent.classList.remove("show-search");
    }
  });

  // Prevent the click event inside the search content from closing it
  document
    .querySelector(".search-content")
    .addEventListener("click", function (e) {
      e.stopPropagation();
    });
});

function performSearch() {
  const searchTerm = document.getElementById("searchInput").value.trim();

  fetch("../view/components/search-controller.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `searchTerm=${encodeURIComponent(searchTerm)}`,
  })
    .then((response) => response.json())
    .then((data) => {
      const searchResult = document.getElementById("searchResult");

      if (data.success) {
        // Display the found username
        searchResult.innerHTML = `<h2>User Found!</h2>
                        <div class="user-content">
                            <div class="circle-img">

                            <img src="../assets/images/${data.user.user_avatar}" alt="User Avatar">

                            </div>
                            <label class="username">
                            <a href="../user profile/profile.php?username=${data.user.username}">
                              ${data.user.username}</a>
                            </label>
                        </div> `;
      } else {
        // Display "User Not Found" message
        searchResult.innerHTML = "<h2>User Not Found!</h2>";
      }
    })
    .catch((error) => console.error("Error during search:", error));
}