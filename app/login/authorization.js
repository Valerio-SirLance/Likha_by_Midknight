function allowUser() {
    // Get the URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const redirectUrl = urlParams.get('redirect_url');
    const applicationName = urlParams.get('application_name');
  console.log (redirectUrl);
  console.log (applicationName);
    // Check if both parameters are present
    if (!redirectUrl || !applicationName) {
      console.error("Missing required parameters");
      return;
    }
  
    // Prepare the data to be sent in the request
    const requestData = {
      redirect_url: redirectUrl,
      application_name: applicationName,
    };
  
    fetch("token-exchange.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestData),
    })
     .then(response => response.json())
    .then(data => {
      // Check if the response contains the authorization token
      if (data && data.authorization_token) {
        // Log a success message after a successful response
        console.log("Request successful");
  //  window.location.href = "../home/home.php?authorization_token=" + data.authorization_token;
      const authorizationToken = data.authorization_token;
  const redirectUrl = data.redirect_url; // Assuming this is the redirect URL from PHP
  // Append the authorization_token query parameter to the redirect URL
  const newUrl = `${redirectUrl}?authorization_token=${authorizationToken}`;
  
  // Redirect the user to the new URL
  window.location.href = newUrl;
  
      } else {
        // Handle the case where the response does not contain the token
        console.error("Error: Authorization token not found in the response");
      }
    })
      .catch((error) => {
        console.error("Error during logout:", error);
      });
  }
  