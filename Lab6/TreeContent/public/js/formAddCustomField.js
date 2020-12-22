let counter = 1;
function createInput(lang) {
    var elements = [],
        rootElement = document.createElement('div');
    if ( lang === "eng") {
        elements.push('<label for="cf_key">Сustom field:</label>');
        elements.push('<input type="text" placeholder="key" name="cf_key[' + counter + ']" />');
        elements.push('<input type="text" placeholder="Russian value" name="cf_value_rus[' + counter + ']" />');
        elements.push('<input type="text" placeholder="English value" name="cf_value_eng[' + counter + ']" />');
    } else {
        elements.push('<label for="cf_key">Пользовательское поле:</label>');
        elements.push('<input type="text" placeholder="Ключ" name="cf_key[' + counter + ']" />');
        elements.push('<input type="text" placeholder="Значение на русском" name="cf_value_rus[' + counter + ']" />');
        elements.push('<input type="text" placeholder="Значение на английском" name="cf_value_eng[' + counter + ']" />');
    }
        
    rootElement.innerHTML = elements.join('');
    counter++;
    return rootElement;
}

function onClickAddInput(event, lang) {
    var container = document.querySelector('#custom_fields_container'),
        component;

    component = createInput(lang);
    container.appendChild(component);
}

// var addButton = document.getElementById('create-custom-field');
// addButton.addEventListener('click', onClickAddInput);