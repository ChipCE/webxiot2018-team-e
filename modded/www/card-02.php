<div class="card-body">
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
            $sql = "SELECT hum FROM room WHERE id=(SELECT MAX(id) FROM room);";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) 
            {
                if($row = $result->fetch_assoc()) 
                    echo $row["hum"];
            }
            $conn->close();
        ?>
    </p>
    <h5 class="card-title text-center">湿度(%)</h5>
</div>
