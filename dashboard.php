<?php
include "layout/session.php";

if ($_SESSION['role'] !== "admin") {
  header("Location:index.php");
  exit;
}

include "connection/config.php";

$dbconnection = getconnectiontodb();

$sql = "SELECT* FROM users ORDER BY id DESC";
$stmt =  $dbconnection->prepare($sql);
$stmt->execute();

include "layout/header.php";
?>
<div class="container">

  <h1 class="text-center mt-3">dashboard</h1>
  <a class="btn btn-primary" href="add_user.php">add</a><br>
  <table class="table table-hover align text-center">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">firstname</th>
        <th scope="col">lastname</th>
        <th scope="col">email</th>
        <th scope="col">address</th>
        <th colspan="2" scope="col">action</th>

      </tr>
    </thead>
    <tbody>
      <?php
      if ($rows = $stmt->fetchAll()) {
        foreach ($rows as $row) {
      ?>
          <tr>

            <td><?= $row['id']; ?></td>
            <td><?= $row['firstname']; ?></td>
            <td><?= $row['lastname']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= $row['address']; ?></td>
            <td><a class="delete-btn" href="delete_user.php?id=<?= $row['id']; ?>"><i class="bi bi-trash-fill"></i></a></td>
            <td><a class="edit-btn" href="profile.php?id=<?= $row['id']; ?>"><i class="bi bi-pencil-square"></i></a></td>
          </tr>
      <?php
        }
      }
      ?>
    </tbody>
  </table>

</div>

<?php
include "layout/footer.php";
?>