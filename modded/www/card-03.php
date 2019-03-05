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
            $sql = "SELECT light FROM room WHERE id=(SELECT MAX(id) FROM room);";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) 
            {
                if($row = $result->fetch_assoc()) 
                    if($row["light"] == 1)
                        echo '<i class="fa fa-sun-o state-on"></i>';
                    else
                        echo "<i class='fa fa-moon-o state-off'></i>";
            }
            $conn->close();
        ?>
    </p>
    <h5 class="card-title text-center">光センサー</h5>
</div>
