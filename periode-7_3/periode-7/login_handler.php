<?php

session_start();
require_once 'conn.php';

class UserAuthentication {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($email, $password) {
        $query = $this->conn->prepare("SELECT * FROM account WHERE emailadres = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($password, $user['wachtwoord'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['emailadres'];

                // Determine redirection based on email domain
                $redirect_url = $this->determineRedirectUrl($email);
                header("Location: $redirect_url");
                exit();
            } else {
                // Incorrect password
                $this->redirectToLoginPage();
            }
        } else {
            // User not found
            $this->redirectToLoginPage();
        }
    }

    private function determineRedirectUrl($email) {
        if (strpos($email, "@tcrmbo") !== false) {
            return "dashbord.php"; // Redirect to dashboard.php for @tcrmbo users
        } elseif (strpos($email, "@student") !== false) {
            return "student.php"; // Redirect to student.php for @student users
        } else {
            return "default_page.php"; // Redirect to a default page if the email doesn't match any specific condition
        }
    }

    private function redirectToLoginPage() {
        header("Location: login.php");
        exit();
    }
}

$userAuth = new UserAuthentication($conn);

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userAuth->login($email, $password);
}

?>
