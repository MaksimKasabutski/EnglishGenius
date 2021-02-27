function deleteWord(dictionaryid, wordid) {
    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({"dictionaryId": dictionaryid, "wordid": wordid});

    // URL -> WordAPIController/actionDeleteWord
    xhr.open("POST", '/api/word/delete', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                document.location.reload(true)
            } else if (json.result === 'error') {
                alert('Not deleted')
            }
        }
    }
}

let updateForm = document.getElementById('updateWord');
updateForm.onsubmit = function (event) {
    event.preventDefault();

    let servResponse = document.getElementById('response');
    let dictionaryid = document.getElementById('dictionaryid').value;
    let englishWord = document.getElementById('englishWord').value;
    let translation = document.getElementById('translation').value;
    let wordid = document.getElementById('wordid').value;
    let pos = document.getElementById('pos').value;

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({
        "englishWord": englishWord,
        "translation": translation,
        "wordid": wordid,
        "pos": pos
    });

    // URL -> WordAPIController/actionUpdate
    xhr.open("POST", '/api/word/update', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            if(json.result === 'success') {
                servResponse.classList.remove('alert-danger');
                servResponse.classList.add('alert-success');
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
                setTimeout('location.replace("/dictionary/'+dictionaryid+'")', 1000);
            } else if(json.result === 'error') {
                servResponse.classList.add('alert-danger');
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
            }
        }
    }
}