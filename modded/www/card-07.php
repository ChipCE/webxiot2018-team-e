<div class="card-body">
<a href="http://192.168.12.200:1880/mqtt?topic=autoswitch&payload=switch">
    <p class="card-text display-1 text-center">
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
            $sql = "SELECT auto FROM room WHERE id=(SELECT MAX(id) FROM room);";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) 
            {
                if($row = $result->fetch_assoc()) 
                    if($row["auto"] == 1)
                        echo "<i class='fa fa-check-circle-o state-on'></i>";
                    else
                        echo "<i class='fa fa-times-circle-o state-off'></i>";
            }
            $conn->close();
        ?>
    </p>
    <h5 class="card-title text-center">自動モード</h5></a>
</div>
