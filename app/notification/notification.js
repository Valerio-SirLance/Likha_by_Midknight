
function readNotif(id) {

    fetch('../notification/notification-controller.php', {
        method: 'PATCH',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}`,
    })
    .then((response) => {
        if (!response.ok) {            
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text();      
    })
     .then((data) => {
        
        alert(data)
        location.reload();

    })
    .catch((error) => {
        alert('Error:', error.message);
    });
}
function filterNotifications(filter) {
    var notifications = document.querySelectorAll('.notifications');
    notifications.forEach(function (notification) {
        if (filter === 'all') {
            notification.style.display = 'block';
        } else if (filter === 'unread' && !notification.classList.contains('read-notification')) {
            notification.style.display = 'block';
        } else {
            notification.style.display = 'none';
        }
    });
}

function markAllAsRead() {
    fetch('../notification/notification-controller.php', {
        method: 'POST',        
    })
    .then((response) => {
        if (!response.ok) {            
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text();      
    })
     .then((data) => {
        
        alert(data)
        location.reload();

    })
    .catch((error) => {
        alert('Error:', error.message);
    });
}

function goToPost(id) {
    console.log('yo');
}


function logout() {
    fetch("logout.php", {
      method: "POST", // or 'GET' based on your server-side code
      // Add any other headers or configurations as needed
    })
      .then(() => {
        // Redirect to the login page or perform other actions as needed
        window.location.href = "../login/login.php";
      })
      .catch((error) => {
        console.error("Error during logout:", error);
      });
  }