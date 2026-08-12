<?php
include "layout/session.php";


//if redirectid to this page and this condition exists
if (empty($_SESSION['csrf_token'])) {
    header("Location:index.php");
    exit;
}

//************CSRF TOKENS TO PREVENT CSRF ATTAKS *******************//
if ($_SESSION['csrf_token']) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


$email = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_token = $_POST['csrf_token'];
    $session_token = $_SESSION['csrf_token'];

    if (empty($user_token) || !hash_equals($user_token, $session_token)) {
        die('CSRF attack detected');
    }

    //to read and compare the email &pass from db
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "Email and Password should be entered";
    } else {

        include "connection/config.php";
        $databaseconn = getconnectiontodb();

        $stmt = $databaseconn->prepare("SELECT id,firstname,lastname,email,phone,address,password,created_at,role FROM users WHERE email =?");

        $stmt->execute([$email]);

        if ($row = $stmt->fetch()) {


            if (password_verify($password, $row['password'])) {
                $_SESSION["id"] = $row['id'];
                $_SESSION["firstname"] = $row['firstname'];
                $_SESSION["lastname"] = $row['lastname'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["phone"] = $row['phone'];
                $_SESSION["address"] = $row['address'];
                $_SESSION["created_at"] = $row['created_at'];
                $_SESSION["role"] = $row['role'];

                header("Location:index.php");
                exit;
            }
        }
        $error = "Email or Password invalid";
    }
}
include "layout/header.php";
?>

<div class="container  py-5">
    <div class="row justify-content-center align-items-center mt-5">

        <div class="col-md-5">

            <div class="card shadow border-0 rounded-4">

                <div class="card-body p-5">

                    <h2 class="text-center mb-4">
                        Login form
                    </h2>
                    <!-- display error msg -->
                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?= $error ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <form method="POST" novalidate>

                        <!-- POST VALUE OF TOKEN WITHEN THE FORM -->
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Email*</label>
                            <input type="email"
                                class="form-control"
                                name="email" value="<?= $email ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password*</label>
                            <input type="password"
                                class="form-control"
                                name="password">
                        </div>
                        <div class="row mb-3">
                            <div class="col d-grid">
                                <button type="submit"
                                    name="register"
                                    class="btn btn-primary w-100 rounded-3">
                                    login
                                </button>
                            </div>
                            <div class="col d-grid">
                                <a href="index.php" class="btn btn-outline-primary w-100 rounded-3">cancel</a>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>

<?php
include "layout/footer.php";
?>