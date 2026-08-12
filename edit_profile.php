<?php
include "layout/session.php";
if (!isset($_SESSION["email"])) {
    header("Location:login.php");
}

//************CSRF TOKENS TO PREVENT CSRF ATTAKS *******************//
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


include "connection/config.php";
$databaseconn = getconnectiontodb();


if ($_SESSION['role'] == "admin" && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT* FROM users WHERE id= ?";
    $stmt =  $databaseconn->prepare($sql);
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch();
} else {
    $user_id = $_SESSION['id'];
    $user_data = $_SESSION;
}
//if a client tries to break through other user data
if ($_SESSION['role'] !== "admin" && $user_id != $_SESSION['id']) {

    header("Location:profile.php");
    exit;
}


$firstname = $lastname = $email = $phone = $address = $current_password = $new_password = $confirm_new_password =  "";

$firstname_error = $lastname_error = $email_error = $phone_error = $current_password_error = $new_password_error = $confirm_new_password_error =  "";

$error = false;


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user_token = $_POST['csrf_token'];
    $session_token = $_SESSION['csrf_token'];

    if (empty($user_token) || !hash_equals($user_token, $session_token)) {
        die('CSRF attack detected');
    }

    //***************************UPDATE USER DATA*****************************//

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone =  trim($_POST['phone']);
    $address = trim($_POST['address']);


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
    }

    if (!preg_match("/^[0-9]{11}$/", $phone)) {
        $phone_error = "phone number must contain 11 degits";
        $error = true;
    }


    //***************************UPDATE USER PASSWORD **************************//

    $current_password = trim($_POST["current_password"] ?? "");
    $new_password = trim($_POST["new_password"] ?? "");
    $confirm_new_password = trim($_POST["confirm_new_password"] ?? "");

    //على الاقل واحده بس تبقا مليانه ندخل فى سيناريو الفاليديشن و$change_password=true 
    $change_password = !empty($current_password) || !empty($new_password) || !empty($confirm_new_password);
    $id = $user_id;  //$user_id = $session['id'] or $get['id']
    if ($change_password) {

        ////////////////CURRENT PASSWORD ///////////
        if ($id == $_SESSION['id']) {  //type current password of client in its session or of the admin's in its session 

            if (empty($current_password)) {
                $current_password_error = "current password should be entered";
                $error = true;
            } else if (strlen($current_password) < 6) {
                $current_password_error = "password should be not less than 6 chars";
                $error = true;
            } else {

                //compare current pass withe the hashed one in db
                $sql = "SELECT password FROM users WHERE id= ?";
                $stmt = $databaseconn->prepare($sql);
                $stmt->execute([$id]);
                $row = $stmt->fetch();

                if (!$row || ! password_verify($current_password, $row['password'])) {
                    $current_password_error = "Current password is incorrect";
                    $error = true;
                }
            }
        }

        ////////////////NEW PASSWORD ///////////
        if (empty($new_password)) {
            $new_password_error = "new password should be entered";
            $error = true;
        } elseif (strlen($new_password) < 6) {
            $new_password_error = "password should be not less than 6 chars";
            $error = true;
        } else {
            if (empty($confirm_new_password)) {
                $confirm_new_password_error = "you have to confirm your password";
                $error = true;
            } elseif ($confirm_new_password != $new_password) {
                $confirm_new_password_error = "password doesn't match";
                $error = true;
            }
        }
    }

    //**********************************UPDATE THE NEW DATA*********************************************************** */
    if (!$error) {

        if ($change_password) {
            //IF PASS INPUTS ARE NOT EMPTY AND PASSED VALIDATION AND FREE FROM ERRORS
            $hash_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            $sql = "UPDATE users SET firstname =? ,lastname=? ,email=? ,phone=? ,address=? ,password=? WHERE id= ? ";
            $stmt = $databaseconn->prepare($sql);
            $stmt->execute([
                $firstname,
                $lastname,
                $email,
                $phone,
                $address,
                $hash_new_password,
                $id
            ]);
        } else {
            /////IF PASS FIELDS ARE EMPTY $change_password=false /////
            $sql = "UPDATE users SET firstname =? ,lastname=? ,email=? ,phone=? ,address=? WHERE id= ? ";
            $stmt = $databaseconn->prepare($sql);
            $stmt->execute([
                $firstname,
                $lastname,
                $email,
                $phone,
                $address,
                $id
            ]);
        }

        if ($user_id == $_SESSION['id']) {
            $_SESSION["firstname"] = $firstname;
            $_SESSION["lastname"] = $lastname;
            $_SESSION["email"] = $email;
            $_SESSION["phone"] = $phone;
            $_SESSION["address"] = $address;
        }
        $redirect_url = ($_SESSION['role'] === 'admin' && $id != $_SESSION['id']) ? "profile.php?id=" . $id : "profile.php";
        header("Location: " . $redirect_url);
        exit;
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
                        update user form
                    </h2>


                    <form method="POST" novalidate>

                        <!-- POST VALUE OF TOKEN WITHEN THE FORM -->
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                        <div class="mb-3">
                            <label class="form-label">First name*</label>
                            <input type="text"
                                class="form-control"
                                name="firstname" value="<?= $user_data["firstname"] ?>">
                            <span class="text-danger"><?= $firstname_error ?> </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">last name*</label>
                            <input type="text"
                                class="form-control"
                                name="lastname" value="<?= $user_data["lastname"] ?>">
                            <span class="text-danger"><?= $lastname_error ?> </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">email*</label>
                            <input type="text"
                                class="form-control"
                                name="email" value="<?= $user_data["email"] ?>">
                            <span class="text-danger"> <?= $email_error ?></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">phone*</label>
                            <input type="text"
                                class="form-control"
                                name="phone" value="<?= $user_data["phone"] ?>">
                            <span class="text-danger"> <?= $phone_error ?></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">address*</label>
                            <input type="text"
                                class="form-control"
                                name="address" value="<?= $user_data["address"] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"> current Password*</label>
                            <input type="password"
                                class="form-control"
                                name="current_password">
                            <span class="text-danger"><?= $current_password_error ?></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> new Password*</label>
                            <input type="password"
                                class="form-control"
                                name="new_password">
                            <span class="text-danger"><?= $new_password_error ?></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm new Password*</label>
                            <input type="password"
                                class="form-control"
                                name="confirm_new_password">
                            <span class="text-danger"><?= $confirm_new_password_error ?></span>
                        </div>

                        <div class="row mb-3">
                            <div class="col d-grid">
                                <button type="submit"
                                    name="update_user_data"
                                    class="btn btn-primary w-100 rounded-3">
                                    update user
                                </button>
                            </div>
                            <div class="col d-grid">
                                <a href="profile.php" class="btn btn-outline-primary w-100 rounded-3">cancel</a>
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