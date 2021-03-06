function generateModalForDelete(id, name, url) {
    id = 'modal' + id;
    let elem = document.getElementById(id);
    if (!elem) {
        let html = '<div class="modal fade" id="' + id + '" tabindex="-1" aria-labelledby="exampleModalLabel"\n' +
            '             aria-hidden="true">\n' +
            '            <div class="modal-dialog">\n' +
            '                <div class="modal-content">\n' +
            '                    <div class="modal-header">\n' +
            '                         <h5 class="modal-title">Warning</h5>\n' +
            '                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
            '                    </div>\n' +
            '                    <div class="modal-body">\n' +
            '                        Are you shure you want to permanently delete <strong>' + name + '</strong>?\n' +
            '                    </div>\n' +
            '                    <div class="modal-footer">\n' +
            '                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>\n' +
            '                        <a type="button" class="btn btn-danger" href="' + url + '">Delete</a>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>';
        $('.accordion').append(html);
    }
    $('#' + id).modal('show');
}

function generateModalForRemove(id, name, url) {
    id = 'modal' + id;
    let elem = document.getElementById(id);
    if (!elem) {
        let html = '<div class="modal fade" id="' + id + '" tabindex="-1" aria-labelledby="exampleModalLabel"\n' +
            '             aria-hidden="true">\n' +
            '            <div class="modal-dialog">\n' +
            '                <div class="modal-content">\n' +
            '                    <div class="modal-header">\n' +
            '                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>\n' +
            '                    </div>\n' +
            '                    <div class="modal-body">\n' +
            '                        Are you shure you want to remove <strong>' + name + '</strong> from your list?\n' +
            '                    </div>\n' +
            '                    <div class="modal-footer">\n' +
            '                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>\n' +
            '                        <a type="button" class="btn btn-warning" href="' + url + '">Remove</a>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>';
        $('.accordion').append(html);
    }
    $('#' + id).modal('show');
}

function addDictionaryToUser(dictionaryid, username) {
    let addButton = document.getElementById('addButton'+dictionaryid);

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({"dictionaryId": dictionaryid, "username": username});

    xhr.open("POST", '/api/dictionary/add', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                addButton.setAttribute('disabled', 'disabled');
                addButton.innerHTML = 'Added';
            } else if (json.result === 'error') {
                alert('Not added')
            }
        }
    }
}

function setSessionMaxRows() {
    var selectBox = document.getElementById("session-max-rows");
    var rowsnumber = selectBox.options[selectBox.selectedIndex].value;

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({"rowsnumber": rowsnumber});

    xhr.open("POST", '/api/dictionary/setrows', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json  = JSON.parse(xhr.responseText);
            if(json.result === 'success') {
                location.reload();
            } else alert(json.message);
        }
    }
}
