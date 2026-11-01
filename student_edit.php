<?php
  session_start();
  if (!isset($_SESSION["username"])) {
     header("Location: login.php");
  }

  include("connection.php");

  // Proses update data ketika tombol submit ditekan
  if (isset($_POST["submit"])) {
      $nim           = mysqli_real_escape_string($connection, $_POST["nim"]);
      $nama          = mysqli_real_escape_string($connection, $_POST["nama"]);
      $tempat_lahir  = mysqli_real_escape_string($connection, $_POST["tempat_lahir"]);
      $tanggal_lahir = mysqli_real_escape_string($connection, $_POST["tanggal_lahir"]);
      $fakultas      = mysqli_real_escape_string($connection, $_POST["fakultas"]);
      $jurusan       = mysqli_real_escape_string($connection, $_POST["jurusan"]);
      $ipk           = mysqli_real_escape_string($connection, $_POST["ipk"]);

      $query = "UPDATE student SET nama = '$nama', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', fakultas = '$fakultas', jurusan = '$jurusan', ipk = '$ipk' WHERE nim = '$nim'";
      $result = mysqli_query($connection, $query);

      if($result) {
          header("Location: student_view.php?message=Data berhasil diubah");
      } else {
          die("Query Error: " . mysqli_errno($connection) . " - " . mysqli_error($connection));
      }
  }

  // Ambil data mahasiswa berdasarkan NIM yang dikirim via URL
  if (isset($_GET["nim"])) {
      $nim = mysqli_real_escape_string($connection, $_GET["nim"]);
      $query = "SELECT * FROM student WHERE nim = '$nim'";
      $result = mysqli_query($connection, $query);
      $data = mysqli_fetch_assoc($result);
      
      if (!($data)) {
          header("Location: student_view.php");
      }
  } else {
      header("Location: student_view.php");
  }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Mahasiswa</title>
  <link href="assets/style.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Data Mahasiswa</h1>
    <hr>
    <nav>
      <ul>
        <li><a href="student_view.php">Tampil</a></li>
        <li><a href="student_add.php">Tambah</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <form action="student_edit.php" method="post">
      <fieldset>
        <legend>Edit Mahasiswa</legend>
        <p>
          <label for="nim">NIM : </label>
          <input type="text" name="nim" id="nim" value="<?php echo $data['nim']; ?>" readonly>
        </p>
        <p>
          <label for="nama">Nama : </label>
          <input type="text" name="nama" id="nama" value="<?php echo $data['nama']; ?>">
        </p>
        <p>
          <label for="tempat_lahir">Tempat Lahir : </label>
          <input type="text" name="tempat_lahir" id="tempat_lahir" value="<?php echo $data['tempat_lahir']; ?>">
        </p>
        <p>
          <label for="tanggal_lahir">Tanggal Lahir : </label>
          <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo $data['tanggal_lahir']; ?>">
        </p>
        <p>
          <label for="fakultas">Fakultas : </label>
          <input type="text" name="fakultas" id="fakultas" value="<?php echo $data['fakultas']; ?>">
        </p>
        <p>
          <label for="jurusan">Jurusan : </label>
          <input type="text" name="jurusan" id="jurusan" value="<?php echo $data['jurusan']; ?>">
        </p>
        <p>
          <label for="ipk">IPK : </label>
          <input type="text" name="ipk" id="ipk" value="<?php echo $data['ipk']; ?>">
        </p>
        <p>
          <input type="submit" name="submit" value="Update Data">
        </p>
      </fieldset>
    </form>
  </div>
</body>
</html>
