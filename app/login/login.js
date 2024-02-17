function loginAccount() {
  const email = document.getElementById("email_field").value;
  const password = document.getElementById("password_field").value;
  const modalMessage = document.getElementById("modal_message");
  console.log(email);
  fetch("login-controller.php", {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded",
    },
    body: `email=${email}&password=${password}`,
  })
    .then((response) => {
      return response.text();
    })
    .then((data) => {
      console.log(data);
      if (data === "Login Successful") {
        modalMessage.innerText = "Login Successful!";
        modalMessage.style.color = "green"; // Set text color to green
        var redirectUrl = "../home/home.php";
        console.log(data);
        window.location.href = redirectUrl;
        document.getElementById("my_modal").style.display = "block";
        document.getElementById("btn_close").style.display = "none";
      } else {
        throw new Error("Login failed");
      }
    })
    .catch((error) => {
      console.error("error");
      const errorMessage = "Invalid credentials or user does not exist.";
      // Display error in a modal
      document.getElementById("modal_message").innerText = errorMessage;
      document.getElementById("my_modal").style.display = "block";
    });
}

function handleEnterKeyPress(event) {
  if (event.key === "Enter") {
    loginAccount();
  }
}

document.getElementById("password_field").addEventListener("keydown", handleEnterKeyPress);

function closeModal() {
  document.getElementById("my_modal").style.display = "none";
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
