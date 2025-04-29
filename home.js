function runQuery(queryType) {
    fetch('run_query.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'queryType=' + queryType
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('popup-content').innerHTML = data;
        document.getElementById('popup').style.display = 'block';
    })
    .catch(error => {
        alert('Error: ' + error);
    });
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
}
