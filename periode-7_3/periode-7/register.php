<?php

require_once 'conn.php'; 

class AccountRegistration {
    private $voornaam;
    private $achternaam;
    private $emailadres;
    private $wachtwoord;

    public function __construct($voornaam, $achternaam, $emailadres, $wachtwoord) {
        $this->voornaam = $voornaam;
        $this->achternaam = $achternaam;
        $this->emailadres = $emailadres;
        $this->wachtwoord = $wachtwoord;
    }

    public function registerAccount() {
        global $conn;

        $sql = "INSERT INTO account (voornaam, achternaam, emailadres, wachtwoord) VALUES (?, ?, ?, ?)";
        $query = $conn->prepare($sql);
        $query->bind_param('ssss', $this->voornaam, $this->achternaam, $this->emailadres, $this->wachtwoord);

        // Execute the query
        $query->execute();
    }
}

if(isset($_POST['submit'])) {
    $voornaam = strip_tags($_POST['voornaam']); 
    $achternaam = strip_tags($_POST['achternaam']); 
    $emailadres = strip_tags($_POST['emailadres']); 
    $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT); 

    $allowed_domains = ['tcrmbo', 'student'];
    $valid_email = false;

    foreach($allowed_domains as $domain) {
        if (strpos($emailadres, "@$domain") !== false) {
            $valid_email = true;
            break;
        }
    }

    if(!$valid_email) {
        echo "<script>alert('Alleen registreren met @tcrmbo of @student voor toegang.')</script>";
        header("Location: index.php");
    } else {
        $accountRegistration = new AccountRegistration($voornaam, $achternaam, $emailadres, $wachtwoord);
        $accountRegistration->registerAccount();
        header("Location: login.php");
        echo "<script>alert('Account succesvol geregistreerd!');</script>";
    }
}

?>
