let createWordlist = document.getElementById('createWordlist');
let servResponse = document.getElementById('response');

createWordlist.onsubmit = function (event) {
    event.preventDefault();

    let wordlistName = document.getElementById('wordlistName').value;
    let wordlistDiscription = document.getElementById('wordlistDiscription').value;
    let isPublic = document.getElementById('isPublic').checked;

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({"wordlistName": wordlistName, "wordlistDiscription": wordlistDiscription, "isPublic": isPublic });

    xhr.open("POST", '/api/dictionary/create', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            servResponse.style.display = 'block';
            servResponse.textContent = json.message;
            if(json.result == 'success') {
                setTimeout('location.replace("/profile")',2000);
            }
        }
    }
}