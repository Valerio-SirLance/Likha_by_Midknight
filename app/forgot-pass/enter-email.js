const forgotpassForm = document.getElementById("forgotpass_form");

forgotpassForm.addEventListener("submit", function (event) {
    
    event.preventDefault(); 
    const email = document.getElementById('email').value
    var modalMessage = document.getElementById("modal_message");
    var modalHelp = document.getElementById("my_modal");

    fetch('enter-email-controller.php', {
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
        },
        body: `email=${email}`,
    })
    // .then((response) => {
    //     if (!response.ok) {            
    //         throw new Error(`HTTP error! Status: ${response.status}`);
    //     }
    //     return response.text();      
    // })
    .then((response) => response.json())
    .then((data) => {
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
      const emailInput = document.getElementById('email');
      emailInput.value = '';
    })
    .catch((error) => {
        console.log("Error:", error.message);
        modalMessage.innerText = error.message;
        modalMessage.style.color = "red";
        document.getElementById("my_modal").style.display = "block";
    });
    

})

function closeModal() {
    document.getElementById("my_modal").style.display = "none";
  }
  function showLoadingModal(){
    document.getElementById('loading_modal').style.display = 'block';
  }
  function hideLoadingModal() {
    document.getElementById('loading_modal').style.display = 'none';
  }