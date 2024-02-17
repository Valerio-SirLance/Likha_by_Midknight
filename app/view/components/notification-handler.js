document.addEventListener("DOMContentLoaded", function () {
    const badge = document.getElementById('notif-badge-sidebar').value;
    const circle = document.getElementById('circle');
    const text = parseInt(document.getElementById('badge-text').textContent); // Use textContent instead of value
    const notifHead = document.getElementById('notif-head');
    
    if (badge === '1') {
        if (text === 0) {
            circle.style.display = 'none';
            notifHead.style.left = '0px';
        } else {
            circle.style.display = 'flex';
        }
    } else {
        circle.style.display = 'none';
        notifHead.style.left = '0px';
    }

    function getNotifCount() {
        fetch('../notification/notification-controller.php', {
            method: 'GET',         
        })
        .then((response) => {
            if (!response.ok) {            
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();      
        })
        .then((data) => {
            const badgeText = document.getElementById('badge-text');
            badgeText.textContent = data.trim(); // Trim any whitespace
            const count = parseInt(data.trim());
            
            if (count === 0) {
                circle.style.display = 'none';
                notifHead.style.left = '0px';
            } else {
                circle.style.display = 'flex';
            }
        })
        .catch((error) => {
            console.error('Error:', error.message);
        });
    }
    getNotifCount();
});

document.getElementById("notif_btn").addEventListener("click", function (e) {
        
    console.log("Notification Button Clicked");
    const searchContent = document.querySelector(".search-content");

    // Close search content if it's open
    if (searchContent.classList.contains("show-search")) {
        searchContent.classList.remove("show-search");
    }

    e.stopPropagation();
    const notifContent = document.querySelector(".notification-container");
    
    notifContent.classList.toggle("show-notif"); // Toggle the "show-notif" class
    // notifContent.style.opacity = '1';
});

// Handle clicks outside the notification content and the notification button
document.addEventListener("click", function (e) {
    const notifContent = document.querySelector(".notification-container");
    const notifBtn = document.getElementById("notif_btn");

    if (
        notifContent &&
        notifBtn &&
        !notifContent.contains(e.target) &&
        e.target !== notifBtn
    ) {
        // notifContent.style.opacity = '0';
        notifContent.classList.remove("show-notif");
    }
});

// Prevent the click event inside the notification content from closing it
document
    .querySelector(".notification-container")
    .addEventListener("click", function (e) {
        e.stopPropagation();
    });