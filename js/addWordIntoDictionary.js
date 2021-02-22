let addWordIntoDictionary = document.getElementById('addWordIntoDictionary');
let servResponse = document.getElementById('response');
let modalWindow = document.getElementById('modal_addWord_window');

addWordIntoDictionary.onsubmit = function (event) {
    event.preventDefault();

    let englishWord = document.getElementById('englishWord').value;
    let translation = document.getElementById('translation').value;
    let dictionaryid = document.getElementById('dictionaryid').value;

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({"englishWord": englishWord, "translation": translation, "dictionaryid": dictionaryid});

    xhr.open("POST", '/api/word/add', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            modalWindow.style.height = '260px';
            servResponse.style.display = 'block';
            servResponse.textContent = json.message;
            if (json.result == 'success') {
                modalWindow.style.height = '260px';
                document.getElementById("englishWord").value = "";
                document.getElementById('translation').value = "";
                setTimeout('servResponse.style.display = \'none\'; modalWindow.style.height = \'230px\';', 1000);

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
