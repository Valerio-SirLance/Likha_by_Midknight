// script.js
// You can add your JavaScript logic here
// For example, fetching images from an API and displaying them in the gallery

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
  fetch("../controller/home-controller.php", {
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

// document.addEventListener("DOMContentLoaded", function () {
//   var input = document.getElementById("input-tag");
//   var imageName = document.getElementById("image-name");

//   input.addEventListener("change", () => {
//     var inputImage = document.querySelector("input[type=file]").files[0];

//     imageName.innerText = inputImage.name;
//   });
// });

function submitPost() {
  // Get the text from the textarea
  var post = document.getElementById("post_text").value;

  var fileInput = document.getElementById("input-tag");
  // var file = fileInput.files[0];

  // if (!file) {
  //     alert('Please choose a file to upload.');
  //     return;
  // }
  var formData = new FormData();
  formData.append("fileInput", fileInput.files[0]);
  formData.append("post", post);

  fetch("create-post.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then(() => {
      // Clear the text in the textarea after successful submission
      document.getElementById("preview").src = "";
      document.getElementById("preview").style.display = "none";
      document.getElementById("default_image").style.display = "block";
      document.getElementById("image-name").textContent = "";
      document.getElementById("input-tag").value = "";
      document.getElementById("post_text").value = "";
    })
    .catch((error) => {
      alert("Error:", error.message);
    });
}

function previewFile() {
  var preview = document.getElementById("preview");
  var fileInput = document.getElementById("input-tag");
  var defaultImage = document.getElementById("default_image");
  var file = fileInput.files[0];
  var reader = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
  };

  if (file) {
    reader.readAsDataURL(file);
    preview.style.display = "block";
    defaultImage.style.display = "none";
  } else {
    preview.src = "";
  }
}

// Open the avatar modal
function openAvatarModal() {

  document.getElementById("avatarModal").style.display = "flex";
  avatarModal.style.opacity = "1";
}

// Close the avatar modal
function closeAvatarModal() {
  const avatarModal = document.getElementById("avatarModal");
  const modal = document.querySelector(".modal");

  avatarModal.classList.add("fade-out");
  modal.classList.add("fade-out");

  setTimeout(() => {
    avatarModal.style.display = "none";
    modal.style.display = "none";

    avatarModal.classList.remove("fade-out");
    modal.classList.remove("fade-out");
  }, 500);

  // Open the bio modal after closing the avatar modal
  openBioModal();
}

// Open the bio modal
function openBioModal() {
  document.getElementById("bioModal").style.display = "flex";
  bioModal.style.opacity = "1";
}

// Close the bio modal
function closeBioModal() {
  const bioModal = document.getElementById("bioModal");
  const modal = document.querySelector(".modal");

  bioModal.classList.add("fade-out");
  modal.classList.add("fade-out");

  setTimeout(() => {
    bioModal.style.display = "none";
    modal.style.display = "none";

    bioModal.classList.remove("fade-out");
    modal.classList.remove("fade-out");
  }, 500);
}

function selectAvatar(img_name) {

  const allImages = document.querySelectorAll(".avatar-img img");
  allImages.forEach((img) => {
    img.classList.remove("selected-avatar");
  });

  const selectedImage = document.querySelector(`.avatar-img img[src="../assets/images/${img_name}"]`);
  if (selectedImage) {
    selectedImage.classList.add("selected-avatar");
  }

  localStorage.setItem("avatar", img_name);
}

function submitBio() {
  // Get the comment value from the text field
  var bioInput = document.getElementById("bio_input").value;
  var avatarImg = localStorage.getItem("avatar");

  console.log(bioInput);
  console.log(avatarImg);

  // Use Fetch API to send the comment value to your PHP script
  fetch("edit-profile.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body:
      "avatar=" +
      encodeURIComponent(avatarImg) +
      "&bio=" +
      encodeURIComponent(bioInput),
  })
    .then((response) => response.json())
    .then((data) => {

      console.log(data.message);
      closeAvatarModal()
      location.reload();
    })
    .catch((error) => console.error("Error:", error));
}
// FOR SHARE FRONTEND
function openShareModal() {
    document.getElementById('shareModal').style.display = 'flex';
    shareModal.style.opacity = '1'; 

}

// Close the avatar modal
function closeAvatarModal() {
  const avatarModal = document.getElementById("avatarModal");
  const modal = document.querySelector(".modal");

  avatarModal.classList.add("fade-out");
  modal.classList.add("fade-out");

  setTimeout(() => {
    avatarModal.style.display = "none";
    modal.style.display = "none";

    avatarModal.classList.remove("fade-out");
    modal.classList.remove("fade-out");
  }, 500);
}

// Open the bio modal
function openBioModal() {
  document.getElementById("bioModal").style.display = "flex";
  bioModal.style.opacity = "1";
}
