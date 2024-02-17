document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelector(".more-dropdown")
    .addEventListener("click", function (e) {
      e.stopPropagation();
      const dropdownContent = this.querySelector(".dropdown-content");
      dropdownContent.style.display =
        dropdownContent.style.display === "block" ? "none" : "block";
    });

  document.addEventListener("click", function (e) {
    const dropdownContent = document.querySelector(".dropdown-content");
    if (dropdownContent && e.target.closest(".more-dropdown") === null) {
      dropdownContent.style.display = "none";
    }
  });
});

function showMore() {
  const dropdown = document.getElementById("dropdown");

  // Check if the dropdown is currently visible
  const isVisible = dropdown.classList.contains("show-dropdown");

  // Toggle the visibility
  if (isVisible) {
    dropdown.classList.remove("show-dropdown");
  } else {
    dropdown.classList.add("show-dropdown");
  }
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

function likePost(postId) {
  // Create a new FormData object to send data
  const formData = new FormData();
  formData.append("post_id", postId);

  fetch("like-controller.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("Like successful");
      } else {
        // The like action failed, you can handle errors here
        console.error("Error during like:", data.message);
      }
    })
    .catch((error) => {
      console.error("Error during like:", error);
    });
}

function deletePost(postId) {
  console.log(postId);
  fetch("modification.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `post_id=${encodeURIComponent(postId)}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // The deletion action was successful, you can perform additional actions here
        console.log("Deletion successful");
        // Redirect to home.php
        window.location.href = "home.php";
      } else {
        // The deletion action failed, you can handle errors here
        console.error("Error during deletion:", data.message);
        // Optionally display an error message to the user
        alert("Error: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error during like:", error);
    });
}

function toggleEdit() {
  var textarea = document.getElementById("post_text");
  var submitPostButton = document.querySelector(".actions button");
  textarea.readOnly = !textarea.readOnly;
  submitPostButton.classList.toggle("show-actions", !textarea.readOnly);
}

function editPost(postId) {
  // window.location.href = '../posting/edit-post.php'
  // console.log(postId);
  var post = document.getElementById("post_text").value;
  var submitPostButton = document.querySelector(".actions button");
  // console.log(post);

  fetch("../posting/edit-post-controller.php", {
    method: "PATCH",
    headers: {
      "Content-type": "application/x-www-form-urlencoded",
    },
    body: `id=${postId}&caption=${encodeURIComponent(post)}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("HTTP error! Status: ${response.status}");
      }
      return response.text();
    })
    .then((data) => {
      console.log(data);
      submitPostButton.classList.remove("show-actions");
      document.getElementById("post_text").readOnly = true;
      // window.location.href = '../home/home.php'
    })
    .catch((error) => {
      alert("Error:", error.message);
    });
}

let highlightedItemIndex = localStorage.getItem("highlightedItemIndex") || -1;

document.addEventListener("DOMContentLoaded", function () {
  changeEmail();
  if (highlightedItemIndex !== -1) {
    highlightItem(highlightedItemIndex);
  }
});

function handleItemClick(index) {
  highlightItem(index);
  localStorage.setItem("highlightedItemIndex", index);
  document.addEventListener("DOMContentLoaded", function () {
    document
      .querySelector(".more-dropdown")
      .addEventListener("click", function (e) {
        e.stopPropagation();
        const dropdownContent = this.querySelector(".dropdown-content");
        dropdownContent.style.display =
          dropdownContent.style.display === "block" ? "none" : "block";
      });

    document.addEventListener("click", function (e) {
      const dropdownContent = document.querySelector(".dropdown-content");
      if (dropdownContent && e.target.closest(".more-dropdown") === null) {
        dropdownContent.style.display = "none";
      }
    });
  });

  function showMore() {
    const dropdown = document.getElementById("dropdown");

    // Check if the dropdown is currently visible
    const isVisible = dropdown.classList.contains("show-dropdown");

    // Toggle the visibility
    if (isVisible) {
      dropdown.classList.remove("show-dropdown");
    } else {
      dropdown.classList.add("show-dropdown");
    }
  }

  // Call the appropriate function based on the selected item index
  switch (index) {
    case 0:
      // Call the changeEmail function directly
      changeEmail();
      break;
    case 1:
      changePassword();
      break;
    case 2:
      deleteAccount();
      break;
    case 3:
      notifBadge();
      break;
    case 4:
      blockedAccount();
      break;
  }
}

function highlightItem(index) {
  let prevHighlightedItem = document.querySelector(".sub-item.highlighted");
  if (prevHighlightedItem) {
    prevHighlightedItem.classList.remove("highlighted");
  }

  let currentItem = document.querySelectorAll(".sub-item")[index];
  if (currentItem) {
    currentItem.classList.add("highlighted");
  }
}

function changeEmail() {
  // window.location.href =
  //   "/project-midknight/app/settings/components/change-email.php";
  fetch("components/change-email.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      // Update the content of the sub-settings-content div
      document.getElementById("sub_settings_content").innerHTML = data;
    })
    .catch((error) => {
      console.error("Error loading content:", error);
    });
}
function submitChangeEmail() {
  const changeEmailForm = document.getElementById("changeEmailForm");
  var modalEmail = document.getElementById("my_modal");
  var modalMessage = document.getElementById("modal_message");

  if (changeEmailForm) {
    const currentEmail = document.getElementById("currentEmail").value;
    const newEmail = document.getElementById("newEmail").value;
    const password = document.getElementById("password").value;

    fetch("./components/change-email-controller.php", {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded",
      },
      body: `currentEmail=${currentEmail}&newEmail=${newEmail}&password=${password}`,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text();
      })
      .then((data) => {
        // console.log(data.message);
        const jsonData = JSON.parse(data);
        console.log(jsonData.success);
        // alert(data);
        if(jsonData.success == true){
          showLoadingModal();
          setTimeout(function () {
            // Hide loading modal when email sending is complete
            hideLoadingModal();
            // alert('Email sent successfully!');
            console.log(jsonData.message);
            modalMessage.innerText = jsonData.message;
            modalMessage.style.color = "green"; // Set text color to green
            modalEmail.style.display = "block";
            document.getElementById("btn_close").style.display = "none";
            setTimeout(closeModal, 1000);
          }, 3000);
        }
        else{
          // console.log("heheh");
          console.log("Error:", jsonData.message);
          modalMessage.innerText = jsonData.message;
          modalMessage.style.color = "red";
          document.getElementById("my_modal").style.display = "block";
        }
       
      })
      .catch((error) => {
        // alert("Error: " + error.message);
        console.log("Error:", error.message);
        modalMessage.innerText = error.message;
        modalMessage.style.color = "red";
        document.getElementById("my_modal").style.display = "block";
      });
  } else {
    console.error("Change email form not found");
  }
}

function submitDeleteAccount() {
  const password = document.getElementById("deletePassword").value;
  console.log(password);
  fetch("components/delete-account-controller.php", {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded",
    },
    body: `password=${password}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      if (data.includes("Account deleted successfully")) {
        // Redirect to the login page
        window.location.href = "../login/login.php";
      } else {
        console.error("Error deleting account:", data);
      }
    })
    .catch((error) => {
      console.error("Error deleting account:", error);
    });
}

// function submitChangeEmail() {

//   const currEmail = document.getElementById('currentEmail').value;
//   const newEmail = document.getElementById('newEmail').value;
//   const password = document.getElementById('password').value;

//   fetch('./change-email-controller.php', {
//     method: 'POST',
//     headers: {
//         'Content-type': 'application/x-www-form-urlencoded',
//     },
//     body: `currEmail=${currEmail}&newEmail=${newEmail}&password=${password}`,
//   })
//   .then((response) => {
//       if (!response.ok) {
//           throw new Error(`HTTP error! Status: ${response.status}`);
//       }
//       return response.text();
//   })
//   .then((data) => {
//       alert(data);

//   })
//   .catch((error) => {
//       alert('Error:', error.message);
//   });

// }
function changePassword() {
  fetch("components/change-password.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      // Update the content of the sub-settings-content div
      document.getElementById("sub_settings_content").innerHTML = data;
    })
    .catch((error) => {
      console.error("Error loading content:", error);
    });
}
function submitChangePassword() {
  // window.location.href =
  //   "/project-midknight/app/settings/components/change-password.php";
  const currPass = document.getElementById("currentPassword").value;
  const newPass = document.getElementById("newPassword").value;
  const confirmNewPass = document.getElementById("confirmNewPassword").value;

  if (newPass === confirmNewPass) {
    fetch("components/change-password-controller.php", {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded",
      },
      body: `currPass=${currPass}&newPass=${newPass}`,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text();
      })
      .then((data) => {
        // Update the content of the sub-settings-content div
        alert(data);
        document.getElementById("sub_settings_content").innerHTML = data;
      })
      .catch((error) => {
        console.error("Error loading content:", error);
      });
  } else {
    alert("New Password and Confirm Password don't match");
  }
}

function deleteAccount() {
  fetch("components/delete-account.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      // Update the content of the sub-settings-content div
      document.getElementById("sub_settings_content").innerHTML = data;
    })
    .catch((error) => {
      console.error("Error loading content:", error);
    });
}

function notifBadge() {


  fetch(`components/notif-badge.php`)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      // Update the content of the sub-settings-content div
      document.getElementById("sub_settings_content").innerHTML = data;
      const isTrue = document.getElementById('notif-badge').value;
      const badgeCheckbox = document.getElementById('badge-checkbox')
      if (isTrue === '1') {        
        badgeCheckbox.checked = true;
      } else {
        badgeCheckbox.checked = false;
      }
    })
    .catch((error) => {
      console.error("Error loading content:", error);
    });
}

function submitBadgeModal() {
  
  const value = document.getElementById('badge-checkbox').checked
  fetch("notif-badge-controller.php", {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded",
    },
    body: `state=${value}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      // Update the content of the sub-settings-content div      
      document.getElementById('myModal').style.display = 'flex';
    
      
    })
    .catch((error) => {
      console.error("Error loading content:", error);
    });
  
}
function closeBadgeModal() {
  document.getElementById('myModal').style.display = 'none';
  window.location.href = '../../app/home/home.php'
}

function blockedAccount() {
  fetch("components/blocked-accounts.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      // Update the content of the sub-settings-content div
      document.getElementById("sub_settings_content").innerHTML = data;
    })
    .catch((error) => {
      console.error("Error loading content:", error);
    });
}

function showPass() {
  const passwordField = document.getElementById("password_field");
  const hidePassIcon = document.getElementById("hide_pass");
  const showPassIcon = document.getElementById("show_pass");
  passwordField.type = "text";
  hidePassIcon.style.display = "none";
  showPassIcon.style.display = "inline-block";
}

function hidePass() {
  const passwordField = document.getElementById("password_field");
  const hidePassIcon = document.getElementById("hide_pass");
  const showPassIcon = document.getElementById("show_pass");

  showPassIcon.addEventListener("click", () => {
    passwordField.type = "password";
    showPassIcon.style.display = "none";
    hidePassIcon.style.display = "inline-block";
  });
}

function showPass1() {
  const passwordField = document.querySelector(".password_field");
  const hidePassIcon = document.getElementById("hide_pass");
  const showPassIcon = document.getElementById("show_pass");
  passwordField.type = "text";
  hidePassIcon.style.display = "none";
  showPassIcon.style.display = "inline-block";
}

function hidePass1() {
  const passwordField = document.querySelector(".password_field");
  const hidePassIcon = document.getElementById("hide_pass");
  const showPassIcon = document.getElementById("show_pass");

  showPassIcon.addEventListener("click", () => {
    passwordField.type = "password";
    showPassIcon.style.display = "none";
    hidePassIcon.style.display = "inline-block";
  });
}

function showPass2() {
  const passwordField = document.querySelector(".password_field1");
  const hidePassIcon = document.getElementById("hide_pass1");
  const showPassIcon = document.getElementById("show_pass1");
  passwordField.type = "text";
  hidePassIcon.style.display = "none";
  showPassIcon.style.display = "inline-block";
}

function hidePass2() {
  const passwordField = document.querySelector(".password_field1");
  const hidePassIcon = document.getElementById("hide_pass1");
  const showPassIcon = document.getElementById("show_pass1");

  showPassIcon.addEventListener("click", () => {
    passwordField.type = "password";
    showPassIcon.style.display = "none";
    hidePassIcon.style.display = "inline-block";
  });
}

function showPass3() {
  const passwordField = document.querySelector(".password_field2");
  const hidePassIcon = document.getElementById("hide_pass2");
  const showPassIcon = document.getElementById("show_pass2");
  passwordField.type = "text";
  hidePassIcon.style.display = "none";
  showPassIcon.style.display = "inline-block";
}

function hidePass3() {
  const passwordField = document.querySelector(".password_field2");
  const hidePassIcon = document.getElementById("hide_pass2");
  const showPassIcon = document.getElementById("show_pass2");

  showPassIcon.addEventListener("click", () => {
    passwordField.type = "password";
    showPassIcon.style.display = "none";
    hidePassIcon.style.display = "inline-block";
  });
}
function closeModal() {
  document.getElementById("my_modal").style.display = "none";
}
function showLoadingModal() {
  document.getElementById("loading_modal").style.display = "block";
}
function hideLoadingModal() {
  document.getElementById("loading_modal").style.display = "none";
}

// FOR SHARE FRONTEND
function openShareModal() {
  document.getElementById("shareModal").style.display = "flex";
  shareModal.style.opacity = "1";
}

function closeShareModal() {
  const shareModal = document.getElementById("shareModal");
  const modal = document.querySelector(".modal");

  shareModal.classList.add("fade-out");
  modal.classList.add("fade-out");

  setTimeout(() => {
    shareModal.style.display = "none";
    modal.style.display = "none";

    shareModal.classList.remove("fade-out");
    modal.classList.remove("fade-out");
  }, 500);
}