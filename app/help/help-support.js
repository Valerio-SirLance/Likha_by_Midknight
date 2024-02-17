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

function submitReport() {
  var problemReport = document.getElementById("problem").value;
  var fileInput = document.getElementById("input-tag");
  var file = fileInput.files[0];
  var modalHelp = document.getElementById("my_modal");
  var modalMessage = document.getElementById("modal_message");
  
  var formData = new FormData();
  formData.append("problem", problemReport);
  formData.append("file", file);

  fetch("help-support-controller.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if(data.success == true){ 
        showLoadingModal();
        setTimeout(function () {
          // Hide loading modal when email sending is complete
          hideLoadingModal();
          // alert('Email sent successfully!');
          console.log(data.message);
          modalMessage.innerText = data.message;
          modalMessage.style.color = "green"; // Set text color to green
          modalHelp.style.display = "block"; 
          document.getElementById("btn_close").style.display = "none";
          setTimeout(closeModal, 1000);
      }, 3000,); 
      }
      else{
        // console.log("heheh");
        console.log("Error:", jsonData.message);
        modalMessage.innerText = jsonData.message;
        modalMessage.style.color = "red";
        document.getElementById("my_modal").style.display = "block";
      }
    })
    .catch((error) => console.error("Error:", error));
    console.log("Error:", error.message);
        modalMessage.innerText = error.message;
        modalMessage.style.color = "red";
        document.getElementById("my_modal").style.display = "block";
}

function closeModal() {
  document.getElementById("my_modal").style.display = "none";
}
function showLoadingModal(){
  document.getElementById('loading_modal').style.display = 'block';
}
function hideLoadingModal() {
  document.getElementById('loading_modal').style.display = 'none';
}