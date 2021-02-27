var newpassForm = document.getElementById('newpassForm');
var servResponse = document.getElementById('response');

newpassForm.onsubmit = function(event) {
    event.preventDefault();

    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let passwordConf = document.getElementById('passwordConfirm').value;
    let resetLink = document.getElementById('resetLink').value;

    var xhr = new XMLHttpRequest();
    var body = JSON.stringify({"email" : email, "password" : password, "passwordConf" : passwordConf, "resetLink": resetLink});

    xhr.open("POST", '/api/reset/newpass', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                newpassForm.style.display = 'none';
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