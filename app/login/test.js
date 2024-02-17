function logHypeHive() {
  const apiUrl = "https://likha.website/get-token.php";

  fetch("../login-hypehive/login-hypehive.php", {

  });
}
// function logHypeHive() {
//   fetch("../login-hypehive/check-cookies.php", {
//     method: "POST", // or 'GET' based on your server-side code
//     // Add any other headers or configurations as needed
//   })
//     .then((response) => response.json())
//     .then((data) => {
//       console.log("Result:", data);
//       if (data.email && data.username) {
//         // Redirect to a page or perform other actions if the email is present
//         const redirectURL = `../login-hypehive/authorization-hypehive.php?username=${encodeURIComponent(
//           data.username
//         )}&email=${encodeURIComponent(data.email)}`;
//         window.location.href = redirectURL;
//       } else {
//         // Handle the case where the email is not present
//         console.log("Email not found in cookies");
//         var modal = document.getElementById("hypehive_modal");
//         modal.style.display = "block";
//       }
//       // Redirect to the login page or perform other actions based on the result
//     })
//     .catch((error) => {
//       console.error("Error during fetch:", error);
//     });
// }

// function closeHypeHiveModal() {
//   var modal = document.getElementById("hypehive_modal");
//   modal.style.display = "none";
// }
// function hypeHiveSubmit() {
//   const email = document.getElementById("email_hype").value;
//   const password = document.getElementById("password_hype").value;
//   fetch("../login-hypehive/login-hypehive.php", {
//     method: "POST",
//     headers: {
//       "Content-Type": "application/x-www-form-urlencoded",
//     },
//     body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(
//       password
//     )}&action=login`,
//   })
//     .then((response) => {
//       if (!response.ok) {
//         throw new Error(`HTTP error! Status: ${response.status}`);
//       }
//       return response.json(); // Parse the response as JSON
//     })
//     .then((data) => {
//       console.log("Response from server:", data);

//       if (data && data.status === "success") {
//         console.log("Login Successful");
//         const accessToken = data.data.token;
//         const accessTokenString = JSON.stringify(accessToken);

//         // Store the access token in local storage
//         localStorage.setItem("access_token", accessTokenString);
//         const redirectURL = `../login-hypehive/authorization-hypehive.php?username=${encodeURIComponent(
//           data.data.username
//         )}&email=${encodeURIComponent(data.data.email)}`;
//         window.location.href = redirectURL;
//       } else {
//         console.error("Login failed:", data && data.message);
//       }
//     })
//     .catch((error) => {
//       console.error("Error:", error);
//     })
//     .finally(() => {
//       closeHypeHiveModal();
//     });
// }

// function logPostify() {
//   fetch("../login-hypehive/check-cookies.php", {
//     method: "POST", // or 'GET' based on your server-side code
//     // Add any other headers or configurations as needed
//   })
//     .then((response) => response.json())
//     .then((data) => {
//       console.log("Result:", data);
//       if (data.email && data.username) {
//         // Redirect to a page or perform other actions if the email is present
//         const redirectURL = `../login-postify/authorization-postify.php?username=${encodeURIComponent(
//           data.username
//         )}&email=${encodeURIComponent(data.email)}`;
//         window.location.href = redirectURL;
//       } else {
//         // Handle the case where the email is not present
//         console.log("Email not found in cookies");
//         var modal = document.getElementById("postify_modal");
//         modal.style.display = "block";
//       }
//       // Redirect to the login page or perform other actions based on the result
//     })
//     .catch((error) => {
//       console.error("Error during fetch:", error);
//     });
// }

// function closePostifyModal() {
//   var modal = document.getElementById("postify_modal");
//   modal.style.display = "none";
// }

// function postifySubmit() {
//   const email = document.getElementById("email_postify").value;
//   const password = document.getElementById("password_postify").value;
//   const apiUrl = "https://likha.website/api.php";

//   // "../login-postify/login-postify.php"
//   fetch(apiUrl, {
//     method: "POST",
//     headers: {
//       "Content-Type": "application/x-www-form-urlencoded",
//     },
//     body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(
//       password
//     )}&action=login`,
//   })
//     .then((response) => {
//       if (!response.ok) {
//         throw new Error(`HTTP error! Status: ${response.status}`);
//       }
//       return response.json(); // Parse the response as JSON
//     })
//     .then((data) => {
//       console.log("Response from server:", data);

//       if (data && data.status === "success") {
//         console.log("Login Successful");
//         const redirectURL = `../login-postify/authorization-postify.php?username=${encodeURIComponent(
//           data.data.username
//         )}&email=${encodeURIComponent(data.data.email)}`;
//         window.location.href = redirectURL;
//       } else {
//         console.error("Login failed:", data && data.message);
//       }
//     })
//     .catch((error) => {
//       console.error("Error:", error);
//     })
//     .finally(() => {
//       closePostifyModal();
//     });
// }
