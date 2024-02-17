document.addEventListener("DOMContentLoaded", function () {
  document
    .querySelector(".more-dropdown")
    .addEventListener("click", function (e) {
      e.stopPropagation();
      const dropdownContent = this.querySelector(".dropdown-content");

      // Check if dropdownContent is not null before accessing style property
      if (dropdownContent) {
        dropdownContent.style.display =
          dropdownContent.style.display === "block" ? "none" : "block";
      }
    });

  document.addEventListener("click", function (e) {
    const dropdownContent = document.querySelector(".dropdown-content");

    // Check if dropdownContent is not null before accessing style property
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
document.addEventListener("DOMContentLoaded", function () {
  var input = document.getElementById("input-tag");
  var imageName = document.getElementById("image-name");

  input.addEventListener("change", () => {
    var inputImage = document.querySelector("input[type=file]").files[0];

    imageName.innerText = inputImage.name;
  });
});

function submitPost() {
  var post = document.getElementById("post_text").value;
  var fileInput = document.getElementById("input-tag");
  const modalMessage = document.getElementById("modal_message");

  // Check if a file is selected
  if (!fileInput.files[0]) {
    modalMessage.innerText = "Please Upload an Image.";
    modalMessage.style.color = "red";
    document.getElementById("my_modal").style.display = "block";
    return;
  }

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
    .then((data) => {
      try {
        const response = JSON.parse(data);

        if (response.status === "success") {
          modalMessage.innerText = response.message;
          console.log("Success:", response.message);
          modalMessage.style.color = "green";
          var redirectUrl = "../home/home.php";
          console.log(response.message);
          window.location.href = redirectUrl;
          document.getElementById("my_modal").style.display = "block";
          document.getElementById("close_post").style.display = "none";
        } else {
          console.log("Error:", response.message);
          modalMessage.innerText = response.message;
          modalMessage.style.color = "red";
          document.getElementById("my_modal").style.display = "block";
        }
      } catch (error) {
        console.log("Error parsing JSON:", error);

        modalMessage.style.color = "red";
        document.getElementById("my_modal").style.display = "block";
      }
    })
    .catch((error) => {
      console.log("Error:", error.message);
      modalMessage.innerText = error.message;
      modalMessage.style.color = "red";
      document.getElementById("my_modal").style.display = "block";
    });
}


function closeModal() {
  document.getElementById("my_modal").style.display = "none";
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
