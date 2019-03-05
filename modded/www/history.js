$( document ).ready(function() {
    $("#history").load("history_loader.php");
});

var auto_refresh = setInterval(function ()
{
    $("#history").load("history_loader.php").fadeIn("slow");
}, 1000);