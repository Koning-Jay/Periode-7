<?php
require_once 'conn.php'; 
session_start();

// Controleer of de gebruiker is ingelogd
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

class Boek {
    public static function getGereserveerdeBoeken($conn) {
        $sql = "SELECT * FROM boek WHERE reservering_email IS NOT NULL AND reservering_email != ''";
        $result = $conn->query($sql);

        if ($result) {
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $result->free_result();
            return $rows;
        } else {
            echo "Fout bij het uitvoeren van de query: " . $conn->error;
            return null;
        }
    }
}

$boeken = Boek::getGereserveerdeBoeken($conn);

?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.scss">
</head>
<main>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div>
                <a class="navbar-brand" href="dashbord.php"><i class="ph ph-house"></i></a>
                <a class="navbar-brand" href="login.php"><i class="ph ph-user-switch"></i></a>
                <a class="navbar-brand" href="book_add_form.php"><i class="ph ph-stack-plus"></i></a>
                <a class="navbar-brand" href="books.php"><i class="ph ph-books"></i></a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            </div>
        </div>
    </nav>
</header>
    <div id="contentSection">
      <body>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">
                  <div class="contentField">
                    <h3> <span class="fw-light">welkom,</span> <br> <span class="fst-italic fw-bold"><?php echo $_SESSION['email']."!"; ?> </span></h3>
                    <h5 class="pt-3">Alle Gereserveerde boeken:</h5>
                    <?php foreach ($boeken as $boek): ?>
                      <span class="gereserveerdeBoeken">
                         <h6 class="fst-italic fw-bold"><?php echo $boek['naam_boek']; ?></h6><h6 class="ps-2 fw-light pe-2" >door:</h6>
                         <h6 class="fst-italic fw-bold"><?php echo $boek['reservering_email']; ?></h6>
                        </span>
                      <?php endforeach; ?>
                  </div>
                </div>
                <div class="col-12 col-md-9">
                  <div class="contentField">
                    <input id="live_search" class="form-control me-2" type="text" placeholder="Zoek hier een boek" aria-label="search">
                    <div id="searchresult"></div>
                  </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
          $(document).ready(function(){
            $("#live_search").keyup(function(){
              var input = $(this).val();
              // alert(input)
              if(input != ""){
                $.ajax({
                  url:"livesearch.php",
                  method: "POST",
                  data: {input:input},

                  success:function(data){
                    $("#searchresult").html(data);
                    $("#searchresult").css("display", "block");
                  }
                });
              }else{

                $("#searchresult").css("display", "none");
              }
            });
          });
        </script>
      </body>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
              <p>Deze website is mede mogelijk gemaakt door <span class="fw-bold fst-italic">koning Jay</span> en <span class="fst-italic fw-bold">keizer Finn</span>.</p>
          </div>
        </div>
      </div>
  </footer>  
  </main>
  </html>
