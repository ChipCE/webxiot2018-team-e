<?php
    $DEBUG = True;

    session_start();
    if($_SESSION["login"] == False)
    {
        header("Location: login.php");
        die();
    }

    $servername = "10.10.0.1";
    $username = "pi";
    $password = "nullpointer";
    $dbname = "pi";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 
    $sql = "SELECT * FROM room ORDER BY id DESC LIMIT 10";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) 
        {           
            echo "<tr><th scope='row'>"; echo $row["id"]; echo "</th>";
            echo "<td>"; echo $row["led"]; echo "</td>";
            echo "<td>"; echo $row["fan"]; echo "</td>";
            echo "<td>"; echo $row["auto"]; echo "</td>";
            echo "<td>"; echo $row["temp"]; echo "</td>";
            echo "<td>"; echo $row["hum"]; echo "</td>";
            echo "<td>"; echo $row["light"]; echo "</td>";
            echo "<td>"; echo $row["human"]; echo "</td>";
            echo "<td>"; echo $row["time"]; echo "</td></tr>";
        }
    }
    $conn->close();
?>
