function allowHypeUser() {
  const urlParams = new URLSearchParams(window.location.search);
  const email = urlParams.get("email");
  const appName = "HypeHive";
    // Retrieve the access token from local storage
    const storedAccessToken = localStorage.getItem("access_token");
    // console.log("Access Token:", storedAccessToken);
    const storedTimestamp = localStorage.getItem("timestamp");
    // console.log("Timestamp:", storedTimestamp);
  fetch("login-hypehive.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `email=${email}&action=get-token&appname=${appName}`, // Fix the construction of the body
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      console.log("Server response:", data);
      return data; // Return the data to ensure it's passed to the next .then block
    })
    .then((data) => {
     console.log(data.response);
      const redirectURL = `../home/home.php?authorization_token=${encodeURIComponent(
        data.data.authorization_token
      )}`;
      window.location.href = redirectURL;
    })

    .catch((error) => {
      alert("Error: " + error.message);
    });
}
