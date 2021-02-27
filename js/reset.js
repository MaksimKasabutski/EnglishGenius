var resetForm = document.getElementById('resetForm');
var servResponse = document.getElementById('response');

resetForm.onsubmit = function(event) {
    event.preventDefault();

    let email = document.getElementById('email').value;

    var xhr = new XMLHttpRequest();
    var body = JSON.stringify({"email" : email});

    xhr.open("POST", '/api/reset', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                resetForm.style.display = 'none';
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
