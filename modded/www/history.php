<?php
    $DEBUG = True;

    session_start();
    if($_SESSION["login"] == False)
    {
        header("Location: login.php");
        die();
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.css">
    <!-- custom css -->
    <link rel="stylesheet" href="style.css">

    <title>History</title>
  </head>
  <body>
    <!-- Navigation  navbar-dark bg-dark -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">誰でもスマートルーム</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">コントロールパネル</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="history.php">履歴
                    <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">ログアウト</a>
                </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- main content -->
    <div class="container main-container">
        <div class="row main-content">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">照明</th>
                        <th scope="col">エアコン</th>
                        <th scope="col">自動モード</th>
                        <th scope="col">温度</th>
                        <th scope="col">湿度</th>
                        <th scope="col">光センサー</th>
                        <th scope="col">人感センサー</th>
                        <th scope="col">時間</th>
                        </tr>
                    </thead>
                    <tbody id="history">
                        
                    </tbody>
                </table>
            </div>
        <div>
    </div>

    <!-- footer bg-dark -->
    <footer class="fixed-bottom text-center py-2 navbar-dark">
        <div class="container">
            <p class="m-0 text-white">Web×IoT メイカーズチャレンジ2018-19in横須賀</p>
            <a href="https://github.com/ChipTechno/webxiot2018-team-e">Team E - ぬるぽ</a>
        </div>
    </footer>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.3.1.js"></script>
    <script src="popper.js"></script>
    <script src="bootstrap.js"></script>
    <script src="history.js"></script>
    
  </body>
</html>
