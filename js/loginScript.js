document.addEventListener("DOMContentLoaded", function() {
    if (sessionStorage.getItem("username")) {
        document.getElementById("loginButton").innerText = sessionStorage.getItem("username");
    }
});


function showRegister() {
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("registerForm").style.display = "block";
    document.getElementById("employeeRegisterForm").style.display = "none";
}

function showEmployeeRegister() {
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("registerForm").style.display = "none";
    document.getElementById("employeeRegisterForm").style.display = "block";
}

