function generateMod(id, name, url) {
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
            '                        <a type="button" class="btn btn-danger" href="' + url + '">Remove</a>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>';
        $('.accordion').append(html);
    }
    $('#' + id).modal('show');
}