var loginForm = document.getElementById('loginForm');
var servResponse = document.getElementById('response');

loginForm.onsubmit = function(event) {
    event.preventDefault();

    var username = document.getElementById('login').value;
    var password = document.getElementById('password').value;

    var xhr = new XMLHttpRequest();
    var body = JSON.stringify({"username" : username , "password" : password});

    xhr.open("POST", '/api/login', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                loginForm.style.display = 'none';
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
