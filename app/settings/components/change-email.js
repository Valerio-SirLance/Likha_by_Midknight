document.addEventListener("DOMContentLoaded", function () {
  const changeEmailForm = document.getElementById("changeEmailForm");

  if (changeEmailForm) {
    changeEmailForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const currentEmail = document.getElementById("currentEmail").value;
      const newEmail = document.getElementById("newEmail").value;
      const password = document.getElementById("password").value;

      console.log("currentEmail:", currentEmail);
      console.log("newEmail:", newEmail);
      console.log("password:", password);

      fetch("change-email-controller.php", {
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
          alert(data);
        })
        .catch((error) => {
          alert("Error: " + error.message);
        });
    });
  } else {
    console.error("Change email form not found");
  }
});
