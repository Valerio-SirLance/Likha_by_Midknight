// home.js

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
  const formData = new FormData();
  formData.append("post_id", postId);
  
  fetch("like-controller.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const likeIcons = document.querySelectorAll(".like-icon");
        const numLikesElement = document.getElementById("num_likes");

        likeIcons.forEach((icon) => {
          icon.classList.toggle("fa-regular", data.action === "unlike");
          icon.classList.toggle("fa-solid", data.action === "like");
        });
        if (data.likeCount !== undefined) {
          numLikesElement.innerText = data.likeCount + " likes";
          console.log(data.likeCount);
        }
      } else {
        console.error("Error during like:", data.message);
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

function handleKeyPress(event, postId) {
  // Check if the pressed key is Enter (key code 13)
  if (event.keyCode === 13) {
    // Prevent the default behavior (e.g., submitting the form)
    event.preventDefault();

    // Call the postComment function
    postComment(postId);
  }
}

function postComment(postId) {
  // Get the comment value from the text field
  var commentValue = document.getElementById("comment_box").value;

  // Use Fetch API to send the comment value to your PHP script
  fetch("comment-controller.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body:
      "postId=" +
      encodeURIComponent(postId) +
      "&comment=" +
      encodeURIComponent(commentValue),
  })
    .then((response) => response.json())
    .then((data) => {
      appendCommentToUI(data.comment, data.userAvatar);
      console.log(data.userAvatar);
      document.getElementById("comment_box").value = "";
    })
    .catch((error) => console.error("Error:", error));
}
function appendCommentToUI(comment, userAvatar) {
  // Create a new comments container
  var newCommentContainer = document.createElement("div");
  newCommentContainer.className = "comments-container";

  // Add user info
  var userInfo = document.createElement("div");
  userInfo.className = "user-info";
  userInfo.innerHTML = `
      <img src="../assets/images/${userAvatar["avatar-user"]}" alt="User Avatar" class="comment-avatar">
      <p class="username">${comment["comment-user"]}</p>
  `;
  newCommentContainer.appendChild(userInfo);

  // Add user comment
  var userComment = document.createElement("div");
  userComment.className = "user-comment";
  var commentText = document.createElement("p");
  commentText.textContent = comment["comment"];
  userComment.appendChild(commentText);

  var replyButton = document.createElement("button");
  replyButton.id = "btn_reply";
  replyButton.className = "user-comment";
  replyButton.textContent = "Reply";
  replyButton.onclick = function() {
    showReplyField(comment['comment_id']);
  };
  userComment.appendChild(replyButton);
  newCommentContainer.appendChild(userComment);
  // Append the new comment container to the existing comments container
  document.getElementById("commentsContainer").appendChild(newCommentContainer);
}

function showReplyField(commentIndex) {
  var replyFieldId = "reply-field-" + commentIndex;
  var replyField = document.getElementById(replyFieldId);

  if (replyField) {
    var cancelButton = document.getElementById("btn_cancel_reply");
    
    if (!cancelButton) {
      cancelButton = document.createElement("button");
      cancelButton.id = "btn_cancel_reply";
      cancelButton.className = "cancel-button";
      cancelButton.textContent = "Cancel";
      cancelButton.onclick = function () {
        replyField.style.display = "none";
      };

      replyField.appendChild(cancelButton);
    }

    replyField.style.display = "block";
  } else {
    console.error("Reply field not found with ID:", replyFieldId);
  }
}

// function showReplyField(commentIndex) {
//   var allReplyFields = document.querySelectorAll(".reply-field");
  
//   allReplyFields.forEach(function (field) {
//     field.style.display = "none";
//   });

//   var replyFields = document.querySelectorAll(".reply-field" + commentIndex);
//   replyFields.forEach(function (field) {
//     field.style.display = "block";
//   });
// }

function submitReply(commentIndex) {
  var replyInput = document.getElementById("reply-" + commentIndex);
  var replyValue = replyInput.value;

  if (replyValue) {
    fetch("../home/reply-controller.php", {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded",
      },
      body: `commentId=${commentIndex}
      &reply=${encodeURIComponent(replyValue)}`,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json(); // Parse JSON response
      })
      .then((responseData) => {
        if (responseData.status === "success") {
          // var replyContainer = document.getElementById('replyContainer'); // Update with your actual container ID
          var commentContainer = document.getElementById(
            "comment-container-" + commentIndex
          );

          if (commentContainer) {
            var replyContainer =
              commentContainer.querySelector(".reply-container");

            if (replyContainer) {
              // Create a new div element for the reply
              var newReplyDiv = document.createElement("div");
              newReplyDiv.className = "reply";
              newReplyDiv.innerHTML =
                '<span class="bold-username">' +
                responseData.username +
                " :</span> " +
                responseData.reply;

              // Append the new reply to the specific comment's container
              replyContainer.appendChild(newReplyDiv);

              var replyField = document.getElementById(
                "reply-field-" + commentIndex
              );
              replyField.style.display = "none";
            } else {
              console.error(
                "Reply container not found for comment: " + commentIndex
              );
            }
          } else {
            console.error(
              "Comment container not found for index: " + commentIndex
            );
          }
        } else {
          alert("Error: " + responseData.message);
        }
      })
      .catch((error) => {
        alert("Error: " + error.message);
      });
  }
}


// FOR SHARE FRONTEND
function openShareModal(postId) {
  document.getElementById("shareModal").style.display = "flex";
  console.log("Opening delete confirmation modal for post ID: " + postId);
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

function deletePostAndRedirect(postId) {
  console.log("Deleting post with ID: " + postId);
  
  // Send an AJAX request to delete the post
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
        // The deletion action was successful
        console.log("Deletion successful");
        
        // Redirect to home.php
        window.location.href = "home.php";
      } else {
        // The deletion action failed, handle errors
        console.error("Error during deletion:", data.message);
        alert("Error: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error during deletion:", error);
      alert("Error: " + error.message);
    });
}