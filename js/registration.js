var registrationForm = document.getElementById('registrationForm')
var servResponse = document.getElementById('response');

registrationForm.onsubmit = function(event) {
    event.preventDefault();

    var username = document.getElementById('login').value;
    var password = document.getElementById('password').value;
    var passwordConf = document.getElementById('passwordConfirm').value;
    var email = document.getElementById('email').value;

    var xhr = new XMLHttpRequest();
    var body = JSON.stringify({"username" : username , "password" : password, "passwordConf" : passwordConf, "email" : email});

    xhr.open("POST", '/api/registration', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4 && xhr.status === 200) {
            var json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                registrationForm.style.display = 'none';
                servResponse.classList.remove('alert-danger');
                servResponse.classList.add('alert-success');
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
                setTimeout('location.replace("/profile")',1000);
            } else {
                servResponse.classList.add('alert-danger');
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
            }
        }
    }
}