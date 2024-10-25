<!DOCTYPE html>
<html lang="en">
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
<body>

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


  <div id="registerField">
    <div class="container">
                <div class="row">
                    <form action="book_add.php" method="post" enctype="multipart/form-data">  
                      <div class="col-12">
                        <div class="row">
                          <div class="mb-3 col-6">
                              <label for="exampleInputEmail1" class="form-label">
                                <h4>Boek naam</h4>
                              </label>
                            <input required name="naam_boek" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                          </div>
  
                          <div class="mb-3 col-6">
                              <label for="exampleInputEmail1" class="form-label">
                                <h4>auteur</h4>
                              </label>
                            <input required name="auteur" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>

                            <div class="mb-3 col-6">
                              <label for="exampleInputEmail1" class="form-label">
                                <h4>uitgever</h4>
                              </label>
                            <input required name="uitgever" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>

                            <div class="mb-3 col-6">
                              <label for="exampleInputEmail1" class="form-label">
                                <h4>boekJaar</h4>
                              </label>
                            <input required name="boekjaar" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>

                            <div class="mb-3 col-6">
                              <label for="exampleInputEmail1" class="form-label">
                                <h4>Beschrijving</h4>
                              </label>
                            <input required name="beschrijving" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>

                            
                            <div class="mb-3 col-6">
                              <label for="exampleInputEmail1" class="form-label">
                                <h4>vooraad</h4>
                              </label>
                            <input required name="vooraad" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                          </div>
                        </div>
                        <div class="btn">
                            <a href="dashbord.php">Home</a>
                        </div>
                        <div class="btn">
                          <input type="submit" value="toevoegen" name="submit">
                        </div>
                    </form>
                </div>
            </div>
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
</body>
</html>