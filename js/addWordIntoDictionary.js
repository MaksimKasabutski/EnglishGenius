let addForm = document.getElementById('addWordIntoDictionary');
let servResponse = document.getElementById('response');

addForm.onsubmit = function (event) {
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

    // URL -> WordAPIController/actionAdd
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
                addForm.reset();
                setTimeout('servResponse.style.display = \'none\'', 1500);
            }
        }
    }
}