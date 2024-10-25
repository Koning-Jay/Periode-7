<?php
require_once 'conn.php'; 

if (isset($_GET['naam_boek'])) {
    $naam_boek = $_GET['naam_boek'];
    $delete = mysqli_query($conn, "DELETE FROM boek WHERE naam_boek = '$naam_boek'");
    if (!$delete) {
        // Behandelen van mislukte verwijdering
        echo "Fout: " . mysqli_error($conn);
    }
}

if (isset($_POST['reserveer'])) {
    $naam_boek = $_POST['naam_boek'];
    $email = $_POST['email'];

    // Controleren of het boek beschikbaar is en er voorraad is
    $check_query = "SELECT * FROM boek WHERE naam_boek = '$naam_boek' AND beschikbaarheid = 1 AND vooraad > 0";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Het boek is beschikbaar en er is voorraad
        $update_query = "UPDATE boek SET vooraad = vooraad - 1, reservering_email = '$email' WHERE naam_boek = '$naam_boek'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            // Voorraad succesvol bijgewerkt en reservering gemaakt
        } else {
            echo "Fout bij het maken van de reservering: " . mysqli_error($conn);
        }
    } else {
        // Het boek is niet beschikbaar of er is geen voorraad
        echo "Het geselecteerde boek is niet beschikbaar of er is geen voorraad.";
    }
}

class Boekenlijst {
    public static function krijgBoeken($conn) {
        $sql = "SELECT *, CASE WHEN beschikbaarheid = 1 THEN 'Beschikbaar' ELSE 'Niet beschikbaar' END AS beschikbaarheid_tekst FROM boek";
        $result = $conn->query($sql);

        if ($result) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            return $rows;
        } else {
            echo "Fout bij het uitvoeren van de query: " . $conn->error;
            return null;
        }
    }
}

$boeken = Boekenlijst::krijgBoeken($conn);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boeken</title>
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
                <a class="navbar-brand" href="student.php"><i class="ph ph-house"></i></a>
                <a class="navbar-brand" href="login.php"><i class="ph ph-user-switch"></i></a>
                <a class="navbar-brand" href="books.php"><i class="ph ph-books"></i></a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            </div>
        </div>
    </nav>
</header>
<div id="contentSection">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span class="bookList">
                <table class="table ">
                    <thead>
                    <tr>
                        <th><h4>Naam</h4></th>
                        <th><h4>Auteur</h4></th>
                        <th><h4>Uitgever</h4></th>
                        <th><h4>Boekjaar</h4></th>
                        <th><h4>Beschrijving</h4></th>
                        <th><h4>Voorraad</h4></th>
                        <th><h4>Beschikbaarheid</h4></th>
                        <th></th> <!-- Kolom voor de knop -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($boeken as $boek): ?>
                        <tr>
                            <td><h6><?php echo $boek['naam_boek']; ?></h6></td>
                            <td><h6><?php echo $boek['auteur']; ?></h6></td>
                            <td><h6><?php echo $boek['uitgever']; ?></h6></td>
                            <td><h6><?php echo $boek['boekjaar']; ?></h6></td>
                            <td><h6><?php echo $boek['beschrijving']; ?></h6></td>
                            <td><h6><?php echo $boek['vooraad']; ?></h6></td>
                            <td><h6><?php echo $boek['beschikbaarheid_tekst']; ?></h6></td>
                            <td>
                                <?php if ($boek['beschikbaarheid'] == 1): ?>
                                    <form class="reserveren" method="post">
                                        <input type="hidden" name="naam_boek" value="<?php echo $boek['naam_boek']; ?>">
                                        <input type="email" name="email" placeholder="Uw e-mailadres" required>
                                        <button class="btn" type="submit" name="reserveer" class="btn btn-primary">Reserveren</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                                </span>
            </div>
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
