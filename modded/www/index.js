$( document ).ready(function() {
    $("#card-01").load("card-01.php");
    $("#card-02").load("card-02.php");
    $("#card-03").load("card-03.php");
    $("#card-04").load("card-04.php");
    $("#card-05").load("card-05.php");
    $("#card-06").load("card-06.php");
    $("#card-07").load("card-07.php");
    $("#card-08").load("card-08.php");
});


var auto_refresh = setInterval(function ()
{
    $("#card-01").load("card-01.php").fadeIn("slow");
    $("#card-02").load("card-02.php").fadeIn("slow");
    $("#card-03").load("card-03.php").fadeIn("slow");
    $("#card-04").load("card-04.php").fadeIn("slow");
    $("#card-05").load("card-05.php").fadeIn("slow");
    $("#card-06").load("card-06.php").fadeIn("slow");
    $("#card-07").load("card-07.php").fadeIn("slow");
}, 1000);

function switchLed()
{
    alert("led");
};
