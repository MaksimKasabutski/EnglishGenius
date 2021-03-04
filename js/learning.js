let form = document.getElementById('learning-form')
let checkButton = document.getElementById('check-button')
let prevButton = document.getElementById('prev-button')
let nextButton = document.getElementById('next-button')

let word = document.getElementById('word').innerText
let counter = document.getElementById('counter').value
let pos = document.getElementById('pos').innerText
let translationInput = document.getElementById('translation')

checkButton.onclick = function (event) {
    event.preventDefault();

    let translation = translationInput.value

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({
        "word": word,
        "translation": translation,
        "counter": counter
    });

    // URL -> LearningAPI -> actionCheck
    xhr.open("POST", '/api/learning/check', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body)

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText)
            if (json.result === 'error') {
                translationInput.classList.remove('right-style')
                translationInput.classList.add('wrong-style')
            } else if (json.result === 'success') {
                translationInput.classList.remove('wrong-style')
                translationInput.classList.add('right-style')
            }
        }
    }
}

prevButton.onclick = function (event) {
    event.preventDefault();

    counter--

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({
        "counter": counter
    });

    // URL -> LearningAPI -> actionNext
    xhr.open("POST", '/api/learning/prev', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText)

            current = document.getElementById('current').innerText
            let total = document.getElementById('total').innerText
            currentValue = current
            currentValue--
            document.getElementById('current').innerText = currentValue
            current = document.getElementById('current').innerText
            if (parseInt(current) !== parseInt(total)) {
                nextButton.removeAttribute('disabled')
            }
            if (parseInt(current) !== 1) {
                prevButton.removeAttribute('disabled')
            } else {
                prevButton.setAttribute('disabled', 'disabled')
            }
            if (json.status === '1') {
                translationInput.classList.remove('wrong-style')
                translationInput.classList.add('right-style')
                document.getElementById('word').innerText = json.word
                document.getElementById('pos').innerText = json.pos
                translationInput.value = json.translation
            } else {
                translationInput.classList.remove('wrong-style')
                translationInput.classList.remove('right-style')
                document.getElementById('word').innerText = json.word
                document.getElementById('pos').innerText = json.pos
                form.reset();
            }
        }
    }
}

nextButton.onclick = function (event) {
    event.preventDefault()

    counter++

    let xhr = new XMLHttpRequest();
    let body = JSON.stringify({
        "counter": counter
    });

    // URL -> LearningAPI -> actionNext
    xhr.open("POST", '/api/learning/next', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let json = JSON.parse(xhr.responseText)

            current = document.getElementById('current').innerText
            let total = document.getElementById('total').innerText
            currentValue = current
            currentValue++
            document.getElementById('current').innerText = currentValue
            current = document.getElementById('current').innerText
            if (parseInt(current) === parseInt(total)) {
                nextButton.setAttribute('disabled', 'disabled')
            }
            if (parseInt(current) !== 1) {
                prevButton.removeAttribute('disabled')
            }
            if (json.status === '1') {
                translationInput.classList.remove('wrong-style')
                translationInput.classList.add('right-style')
                document.getElementById('word').innerText = json.word
                document.getElementById('pos').innerText = json.pos
                translationInput.value = json.translation
            } else {
                translationInput.classList.remove('wrong-style')
                translationInput.classList.remove('right-style')
                document.getElementById('word').innerText = json.word
                document.getElementById('pos').innerText = json.pos
                form.reset();
            }

        }
    }
}