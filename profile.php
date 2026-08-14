<?php
include "layout/session.php";

//if redirectid to this page and thiss condition exists
if (!isset($_SESSION["email"])) {
    header("Location:login.php");
}

include "connection/config.php";
$databaseconn = getconnectiontodb();

if ($_SESSION['role'] === "admin" && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT* FROM users WHERE id= ?";
    $stmt =  $databaseconn->prepare($sql);
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch();
} else {
    $user_id = $_SESSION['id'];
    $user_data = $_SESSION;
}

include "layout/header.php";
?>

<div class="container py-5">
    <div class="row  text-center ">
        <div class="col-lg-6 mx-auto border shadow p-4">
            <div class="position-relative mb-4">
                <h2 class="text-center mb-0">profile</h2>
                <!-- if admin want to change clients data or client...  -->
                <a href="edit_profile.php?id=<?= $user_id ?>" class="btn btn-primary position-absolute top-50 end-0 translate-middle-y">Edit</a>
            </div>


            <hr />

            <div class="row mb-3">
                <div class="col-sm-4 fs-5">id</div>
                <div class="col-sm-8 fs-5"> <?= $user_data["id"] ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 fs-5">First name</div>
                <div class="col-sm-8 fs-5"> <?= $user_data["firstname"] ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 fs-5">lastname</div>
                <div class="col-sm-8 fs-5"> <?= $user_data["lastname"] ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 fs-5">email</div>
                <div class="col-sm-8 fs-5"> <?= $user_data["email"] ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 fs-5">phone</div>
                <div class="col-sm-8 fs-5"> <?= $user_data["phone"] ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 fs-5">address</div>
                <div class="col-sm-8 fs-5"> <?= $user_data["address"] ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 fs-5">role</div>
                <div class="col-sm-8 fs-5"> <?= $user_data["role"] ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-4 fs-5">regester date</div>
                <div class="col-sm-8 fs-5"> <?= $user_data["created_at"] ?></div>
            </div>

        </div>
    </div>
</div>


<?php
include "layout/footer.php";
?>