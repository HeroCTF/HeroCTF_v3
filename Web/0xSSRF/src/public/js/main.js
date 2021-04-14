var reponseElement = document.getElementById('response');
var hostInput = document.getElementById('hostInput');
var loading = document.getElementById('loading');

loading.style.visibility = "hidden";

function checkHost() {
    reponseElement.innerHTML = '';
    loading.style.visibility = "visible";

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/check');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        loading.style.visibility = "hidden";
        reponseElement.innerHTML = xhr.response;
    };

    xhr.send("host=" + hostInput.value);
}