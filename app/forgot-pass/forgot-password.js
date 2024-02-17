const forgotpassForm = document.getElementById("forgotpass_form");

forgotpassForm.addEventListener("submit", function (event) {
    
    event.preventDefault(); 
    const email = document.getElementById('email').value
    const newPass = document.getElementById('new_pass').value
    console.log(document.getElementById('email').value);
    fetch('forgot-password-controller.php', {
        method: 'POST',
        headers: {
            'Content-type': 'application/x-www-form-urlencoded',
        },
        body: `email=${email}&newPass=${newPass}`,
    })
    .then((response) => {
        if (!response.ok) {            
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text();      
    })
    .then((data) => {
        alert(data);
        window.location.href = "../login/login.php";
    })
    .catch((error) => {
        alert('Error:', error.message);
    });
    

})