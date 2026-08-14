<?php
include "layout/session.php";

//if redirectid to this page and this condition exists
if (isset($_SESSION["email"])) {
    header("Location:index.php");
    exit;
}

//************CSRF TOKENS TO PREVENT CSRF ATTAKS *******************//
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$firstname = "";
$lastname = "";
$email = "";
$phone = "";
$address = "";
$password = "";
$confirm_password = "";

$firstname_error = "";
$lastname_error = "";
$email_error = "";
$phone_error = "";
$password_error = "";
$confirm_password_error = "";

$error = false;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $user_token = $_POST['csrf_token'];
    $session_token = $_SESSION['csrf_token'];

    if (empty($user_token) || !hash_equals($user_token, $session_token)) {
        die('CSRF attack detected');
    }

    include "connection/config.php";
    $databaseconn = getconnectiontodb();

    $firstname = trim($_POST["firstname"] ?? "");
    $lastname = trim($_POST["lastname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirm_password = trim($_POST["confirm_password"] ?? "");


    ////////////////////FIRST NAME VALIDATION///////////////////////////////

    if (empty($firstname)) {
        $firstname_error = "first name should be entered";
        $error = true;
    }

    ////////////////////LAST NAME VALIDATION///////////////////////////////

    if (empty($lastname)) {
        $lastname_error = "last name should be entered";
        $error = true;
    }

    ////////////////////EMAIL VALIDATION//////////////////////////////////
    if (empty($email)) {
        $email_error = "Email shuld be entered";
        $error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "email should be in the right format";
        $error = true;
    } else {

        //check if email is already recorded

        $stmt = $databaseconn->prepare("SELECT id FROM users WHERE email =?");

        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $email_error = "this email is alredy existed";
            $error = true;
        }
    }


    ////////////////////PHONE VALIDATION/////////////////////////////////

    if (!preg_match("/^[0-9]{11}$/", $phone)) {
        $phone_error = "phone number must contain 11 degits";
        $error = true;
    }

    ////////////////////PASSWORD VALIDATION///////////////////////////////
    if (empty($password)) {
        $password_error = "password should be entered ";
        $error = true;
    } elseif (strlen($password) < 6) {
        $password_error = "password should be not less than 6 chars";
        $error = true;
    } elseif ($confirm_password !== $password) {
        $confirm_password_error = "password doesn't match";
        $error = true;
    }

    ///////////////////////////////////////// CREATE NEW USER////////////////////////////////////////////
    if (!$error) {

        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');

        $sql = "INSERT INTO users(firstname , lastname ,email, phone, address, password,created_at) VALUES (?,?,?,?,?,?,?)";

        $stmt = $databaseconn->prepare($sql);

        $stmt->execute([
            $firstname,
            $lastname,
            $email,
            $phone,
            $address,
            $hash_password,
            $created_at
        ]);


        //get the newly regestered data from db to store in session
        $stmt = $databaseconn->prepare("SELECT id,firstname,lastname,email,phone,address,password,created_at,role FROM users WHERE email =?");

        $stmt->execute([$email]);

        if ($row = $stmt->fetch()) {

            ///session values from db///                  
            if (password_verify($password, $row['password'])) {
                $_SESSION["id"] = (int) $row['id'];  //store id in session from string to integer 
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
                        Create Account
                    </h2>

                    <form method="POST" novalidate>

                        <!-- POST VALUE OF TOKEN WITHEN THE FORM -->
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                        <div class="mb-3">
                            <label class="form-label">first name*</label>
                            <input type="text"
                                class="form-control"
                                name="firstname" value="<?= $firstname  ?>">
                            <span class="text-danger"><?= $firstname_error ?></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">last name*</label>
                            <input type="text"
                                class="form-control"
                                name="lastname" value="<?= $lastname  ?>">
                            <span class="text-danger"> <?= $lastname_error ?></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email*</label>
                            <input type="email"
                                class="form-control"
                                name="email" value="<?= $email  ?>">
                            <span class="text-danger"><?= $email_error ?> </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">phone number*</label>
                            <input type="text"
                                class="form-control"
                                name="phone" value="<?= $phone ?>">
                            <span class="text-danger"><?= $phone_error ?> </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">address (optional)</label>
                            <input type="text"
                                class="form-control"
                                name="address" value="<?= $address  ?>">

                        </div>


                        <div class="mb-3">
                            <label class="form-label">Password*</label>
                            <input type="password"
                                class="form-control"
                                name="password">
                            <span class="text-danger"><?= $password_error ?></span>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Confirm Password*</label>
                            <input type="password"
                                class="form-control"
                                name="confirm_password">
                            <span class="text-danger"><?= $confirm_password_error ?></span>
                        </div>


                        <button type="submit"
                            name="register"
                            class="btn btn-primary w-100 rounded-3">
                            Register
                        </button>


                        <p class="text-center mt-3 mb-0">
                            Already have an account?
                            <a href="login.php" class="text-decoration-none">
                                Login
                            </a>
                        </p>

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>


<?php
include "layout/footer.php";
?>