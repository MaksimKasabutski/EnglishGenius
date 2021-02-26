function deleteWord(dictionaryid, wordid) {
    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({"dictionaryId": dictionaryid, "wordid": wordid});
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

function editWord(wordid, word, pos, translate) {
    let row = document.getElementById(wordid);
    row.style.display = 'none';
    let html = '<td>' +
            '<input type="text" value="' + word + '">' +
            '<select id="pos" class="form-select">\n' +
                '<option selected value="'+pos+'">'+pos+'</option>                        ' +
                '<option>-</option>\n' +
'                <option value="noun">noun</option>\n' +
'                <option value="verb">verb</option>\n' +
'                <option value="adverb">adverb</option>\n' +
'                <option value="adjective">adjective</option>\n' +
        '    </select>' +
        '</td>' +
        '<td>' +
        '   <input type="text" value="'+translate+'">' +
        '</td>' +
        '<td>' +
        '   <button class="btn btn-primary btn-sm">Save</button>' +
        '   <button class="btn btn-primary btn-sm" onclick="cancel()">Cancel</button>' +
        '</td>';
    $(row).empty();
    $(row).append(html);
}

function cancel(row, rowContent) {
    row.innerHTML = rowContent;
}