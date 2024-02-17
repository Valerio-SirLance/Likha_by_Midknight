function allowUser() {
  const urlParams = new URLSearchParams(window.location.search);
  const email = urlParams.get("email");
  const appName = "Postify";

  fetch("login-postify.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `email=${email}&action=get-token&appname=${appName}`, 
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text(); // Log the raw response text
    })
    .then((text) => {
      console.log("Server response:", text);
    })
    .then((data) => {
      // Handle the data returned from the server
      if (data && data.data) {
        console.log("User ID:", data.data.user_id);
        console.log("Username:", data.data.username);
        console.log("Email:", data.data.email);
        console.log("Token:", data.data.token);
        console.log("Registration Data:", data.data.registration_data);
      } else {
        console.error("Invalid response structure:", data);
      }
    });
}
