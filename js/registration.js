var registrationForm = document.getElementById('registrationForm')
var servResponse = document.getElementById('response');
var registrationWindow = document.getElementById('registrationWindow');

registrationForm.onsubmit = function(event) {
    event.preventDefault();

    var username = document.getElementsByClassName('login')[1].value;
    var password = document.getElementsByClassName('password')[1].value;
    var passwordConf = document.getElementById('confirm_password').value;
    var email = document.getElementById('email').value;

    var xhr = new XMLHttpRequest();
    var body = JSON.stringify({"username" : username , "password" : password, "passwordConf" : passwordConf, "email" : email});

    xhr.open("POST", '../formshadlers/registration.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4 && xhr.status === 200) {
            var json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                registrationWindow.style.display = 'none';
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
                setTimeout('location.replace("/profile")',1000);
            } else {
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
            }
        }
    }
}