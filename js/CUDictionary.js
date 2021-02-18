let CUDictionary = document.getElementById('CUDictionary');
let servResponse = document.getElementById('response');

CUDictionary.onsubmit = function (event) {
    event.preventDefault();

    let dictionaryId = document.getElementById('dictionaryid').value;
    let dictionaryName = document.getElementById('wordlistName').value;
    let dictionaryDiscription = document.getElementById('wordlistDiscription').value;
    let isPublic = document.getElementById('isPublic').checked;
    let status = document.getElementById('status').value;

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({"dictionaryId": dictionaryId,"dictionaryName": dictionaryName, "dictionaryDiscription": dictionaryDiscription, "isPublic": isPublic });

    if(status === 'Create') {
        xhr.open("POST", '/api/dictionary/create', true);
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.send(body);
    } else if(status === 'Update') {
        xhr.open("POST", '/api/dictionary/update', true);
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.send(body);
    }

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            if(json.result === 'success') {
                servResponse.classList.add('alert-success');
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
                setTimeout('location.replace("/profile")', 1000);
            } else if(json.result === 'error') {
                servResponse.classList.add('alert-danger');
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
            }
        }
    }
}