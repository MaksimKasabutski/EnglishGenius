let addWordIntoDictionary = document.getElementById('addWordIntoDictionary');
let servResponse = document.getElementById('response');
let modalWindow = document.getElementById('modal_addWord');


addWordIntoDictionary.onsubmit = function (event) {
    event.preventDefault();

    let englishWord = document.getElementById('englishWord').value;
    let translation = document.getElementById('translation').value;
    let dictionaryid = document.getElementById('dictionaryid').value;

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({"englishWord": englishWord, "translation": translation, "dictionaryid": dictionaryid});

    xhr.open("POST", '/formshandlers/addWordIntoDictionary.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            servResponse.style.display = 'block';
            servResponse.textContent = json.message;
            if(json.result == 'success') {
                setTimeout('servResponse.style.display = \'none\';',1000);
                setTimeout('modalWindow.style.display = \'none\';', 1000);
            }
        }
    }
}