let form = document.getElementById('addWordIntoDictionary');
let servResponse = document.getElementById('response');

form.onsubmit = function (event) {
    event.preventDefault();

    let englishWord = document.getElementById('englishWord').value;
    let translation = document.getElementById('translation').value;
    let dictionaryid = document.getElementById('dictionaryid').value;
    let pos = document.getElementById('pos').value;

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({
        "englishWord": englishWord,
        "translation": translation,
        "dictionaryId": dictionaryid,
        "pos": pos
    });

    // /api/word/add -> WordAPIController/actionAddWord
    xhr.open("POST", '/api/word/add', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            servResponse.textContent = json.message;
            servResponse.style.display = 'block';
            if (json.result === 'error') {
                servResponse.classList.add('alert-danger');
            } else if (json.result === 'success') {
                servResponse.classList.remove('alert-danger');
                servResponse.classList.add('alert-success');
                form.reset();
                setTimeout('servResponse.style.display = \'none\'', 1500);
            }
        }
    }
}

function DeleteWord(dictionaryId) {
    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({"dictionaryid": dictionaryId});

    xhr.open("POST", '/formshandlers/deleteWord.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            alert(json.message);
        }
    }
}
