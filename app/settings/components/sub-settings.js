const forgotpassForm = document.getElementById("change-password-form");

forgotpassForm.addEventListener("submit", function (event) {
  event.preventDefault();
  const email = document.getElementById("email").value;
  const currPass = document.getElementById("curr_pass").value;
  const newPass = document.getElementById("new_pass").value;

  fetch("../controller/forgot-password.php", {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded",
    },
    body: `email=${email}&currPass=${currPass}
        &newPass=${newPass}`,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      console.log(data);
    })
    .catch((error) => {
      alert("Error:", error.message);
    });
});
