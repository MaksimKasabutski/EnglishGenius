var loginForm = document.getElementById('loginForm');
var servResponse = document.getElementById('response');
var loginWindow = document.getElementById('loginWindow');

loginForm.onsubmit = function(event) {
    event.preventDefault();

    var username = document.getElementsByClassName('login')[0].value;
    var password = document.getElementsByClassName('password')[0].value;

    var xhr = new XMLHttpRequest();
    var body = JSON.stringify({"username" : username , "password" : password});

    xhr.open("POST", '/login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                loginWindow.style.display = 'none';
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
