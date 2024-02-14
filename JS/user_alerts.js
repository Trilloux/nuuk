

function updateTimeCookie() {
    var originalDate = new Date();
    var dateObj = new Date(originalDate);

    var year = dateObj.getFullYear();
    var month = ("0" + (dateObj.getMonth() + 1)).slice(-2);
    var day = ("0" + dateObj.getDate()).slice(-2);
    var hours = ("0" + dateObj.getHours()).slice(-2);
    var minutes = ("0" + dateObj.getMinutes()).slice(-2);
    var seconds = ("0" + dateObj.getSeconds()).slice(-2);

    var time = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
    
    // Saglabā jauno laiku kā sīkdatni ar nosaukumu "current_time"
    document.cookie = "current_time=" + time;
}
setInterval(function() {
    updateTimeCookie();
}, 1000);


function getTaskAlerts() {
    $.ajax({
        url: 'home.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error('Kļūda veicot AJAX pieprasījumu:', error);
        }
    });
}


function loadDoc() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        const responseText = this.responseText.trim(); // Noņemam liekus atstarpes un jaunās līnijas
        const alertCountElement = document.getElementById("alert_count");

        // Iestatām iegūto skaitli kā tekstu
        alertCountElement.innerText = responseText;
    };
    xhttp.open("GET", "alerts/task_data.php", true);
    xhttp.send();
}

setInterval(loadDoc, 1); // Pārbaudīt ik pēc 10 sekundēm
