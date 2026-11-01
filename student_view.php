<?php
  session_start();
  if (!isset($_SESSION["username"])) {
     header("Location: login.php");
  }

  include("connection.php");
  
  if (isset($_GET["message"])) {
      $message = $_GET["message"];
  }
     
  $query = "SELECT * FROM student ORDER BY nim ASC";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Mahasiswa</title>
  <link href="assets/style.css" rel="stylesheet" >
</head>
<body>
  <div class="container">
    <div id="header">
      <h1 id="logo">Data Mahasiswa</h1>
    </div>
    <hr>
    <nav>
      <ul>
        <li><a href="student_view.php">Tampil</a></li>
        <li><a href="student_add.php">Tambah</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <?php
      if (isset($message)) {
          echo "<div class='pesan' style='color: green; margin-bottom: 10px;'><b>$message</b></div>";
      }
    ?>
    <table border="1" cellpadding="8" cellspacing="0">
    <tr>
      <th>NIM</th>
      <th>Nama</th>
      <th>Tempat Lahir</th>
      <th>Tanggal Lahir</th>
      <th>Fakultas</th>
      <th>Jurusan</th>
      <th>IPK</th>
      <th>Aksi</th>
    </tr>
    <?php
      $result = mysqli_query($connection, $query);
      if(!$result) {
          die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
      }
    
      while($data = mysqli_fetch_assoc($result)){ 
        $tanggal_lahir = strtotime($data["tanggal_lahir"]);
        $formatted_date = date("d-m-Y", $tanggal_lahir);
        
        echo "<tr>";
        echo "<td>" . $data["nim"] . "</td>";
        echo "<td>" . $data["nama"] . "</td>";
        echo "<td>" . $data["tempat_lahir"] . "</td>";
        echo "<td>" . $formatted_date . "</td>";
        echo "<td>" . $data["fakultas"] . "</td>";
        echo "<td>" . $data["jurusan"] . "</td>";
        echo "<td>" . $data["ipk"] . "</td>";
        echo "<td>
                <a href='student_edit.php?nim=" . $data["nim"] . "'>Edit</a> | 
                <a href='student_delete.php?nim=" . $data["nim"] . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
              </td>";
        echo "</tr>";
      }
      
      mysqli_free_result($result);
      mysqli_close($connection);
    ?>
    </table>
  </div>
</body>
</html>
