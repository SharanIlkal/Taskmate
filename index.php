<?php 
$insert = false;
$update = false;
$delete = false;
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";
mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect($servername, $username, $password, $database);
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
  if($result){
    $delete = true;
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    $sno = $_POST["snoEdit"];
    $note = $_POST["noteEdit"];
    $description = $_POST["descriptionEdit"];
    $sql = "UPDATE `notes` SET `note` = '$note' , `description` = '$description' WHERE `notes`.`sno` = $sno";
    $result = mysqli_query($conn, $sql);
    if($result){
        $update = true; 
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
  else{
  $note = $_POST["note"];
  $description = $_POST["description"];
  $sql = " INSERT INTO `notes` ( `note`, `description`) VALUES ('$note', '$description') ";
$result = mysqli_query($conn, $sql);
if($result){
  $insert = true;
}
else{
  echo "The note was not added successfully.";
}
}
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TO-DO List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

</head>
<body>
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/TODOLIST/index.php" method="POST">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="noteEdit" class="form-label">Note :</label>
              <input type="text" class="form-control" id="noteEdit" name="noteEdit">
            </div>
            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Description :</label>
              <textarea name="descriptionEdit" id="descriptionEdit" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update note</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<nav class="navbar sticky-top bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><h1>TASKMATE</h1></a>
  </div>
</nav>
  <?php
if($insert){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Sucess!</strong> Your note has been added successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label=Close'></button>
</div>";
}
if($update){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Sucess!</strong> Your note has been updated successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label=Close'></button>
</div>";
}
if($delete){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Sucess!</strong> Your note has been deleted successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label=Close'></button>
</div>";
}
?>
  <div class="container my-5">
   <form action="/TODOLIST/index.php" method="post">
      <h3>Add a Note !</h3>
      <div class="mb-3">
        <label for="note" class="form-label">Note :</label>
        <input type="text" class="form-control" id="note" name="note">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Decsription : </label>
        <textarea name="description" id="description" class="form-control"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>
  <div class="container mb-1">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Note</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
  $sql = "SELECT * FROM `notes`";
  $result = mysqli_query($conn, $sql);
  $sno = 0;
    while($row = mysqli_fetch_assoc($result)){
      $sno = $sno +1;
      echo "    <tr>
      <th scope='row'>" . $sno . "</th>
      <td>" . $row['note'] . "</td>
      <td>" . $row['description'] . "</td>
      <td>
  <button class='btn edit btn-sm btn-primary' id=".$row['sno'].">Edit</button>
  <button class='btn delete btn-sm btn-danger' id=d".$row['sno'].">Delete</button>
</td>

    </tr>";
    }
    ?>
        </tr>
      </tbody>
    </table>
  </div>
  <hr>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>
  <script src="https://cdnVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
    integrity="sha38.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8V4-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        tr = e.target.closest("tr");
        note = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        document.getElementById("noteEdit").value = note;
        document.getElementById("descriptionEdit").value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        let myModal = new bootstrap.Modal(document.getElementById('editModal'));
        myModal.show();
      });
    });
deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach((element)=>{
  element.addEventListener("click", (e)=>{
    sno=e.target.id.substr(1,);
    if(confirm("Are you sure you want to delete this note!")){
      console.log("yes");
      window.location = `/TODOLIST/index.php?delete=${sno}`;
    }
    else{
      console.log("no");
    }
  })
})
</script>
</body>

</html>
