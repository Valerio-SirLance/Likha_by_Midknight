document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("registrationForm")
    .addEventListener("submit", function (event) {
      event.preventDefault(); // Prevent the default form submission

      // Get form data
      let formData = new FormData(this);
      // Display loading modal

      // Make AJAX request
      fetch("registration-controller.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then((data) => {
          // Handle the response from the server
          console.log(data);
          const modalMessage = document.getElementById("modal_message");
          var modalHelp = document.getElementById("my_modal");
          if (data.success) {
            // modalMessage.innerText =
            //   "Registration Successful! Please check your email for verification";
            // modalMessage.style.color = "green"; // Set text color to green
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
            }, 3000);
          } else {
            console.log("Error:", data.message);
            modalMessage.innerText = data.message;
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
    });
});
// Function to close the modal
function closeModal() {
  document.getElementById("my_modal").style.display = "none";
  var formReg = document.getElementById("registrationForm");
  formReg.reset();
  // You can redirect to another page if needed
  // window.location.href = "../view/registration.html";
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

function showConfirmPass() {
  const passwordField = document.getElementById("confirm_password_field");
  const hidePassIcon = document.getElementById("hide_confirm_pass");
  const showPassIcon = document.getElementById("show_confirm_pass");
  passwordField.type = "text";
  hidePassIcon.style.display = "none";
  showPassIcon.style.display = "inline-block";
}
function hideConfirmPass() {
  const passwordField = document.getElementById("confirm_password_field");
  const hidePassIcon = document.getElementById("hide_confirm_pass");
  const showPassIcon = document.getElementById("show_confirm_pass");

  showPassIcon.addEventListener("click", () => {
    passwordField.type = "password";
    showPassIcon.style.display = "none";
    hidePassIcon.style.display = "inline-block";
  });
}
function openTermsModal() {
  // Fetch the content of terms.html
  document.getElementById("terms_condition").classList.add("show-terms-modal");
}

function closeTermsModal() {
  // Remove the class to hide the modal
  document
    .getElementById("terms_condition")
    .classList.remove("show-terms-modal");
}
function showLoadingModal() {
  document.getElementById("loading_modal").style.display = "block";
}
function hideLoadingModal() {
  document.getElementById("loading_modal").style.display = "none";
}
