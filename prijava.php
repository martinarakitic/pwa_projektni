<?php 
session_start();
include 'connect.php'; 

if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['prijava'])) {
    $prijavaImeKorisnika = $_POST['username']; 
    $prijavaLozinkaKorisnika = $_POST['lozinka']; 
    $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?"; 
    $stmt = mysqli_stmt_init($dbc); 
    if (mysqli_stmt_prepare($stmt, $sql)) { 
        mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika); 
        mysqli_stmt_execute($stmt); 
        mysqli_stmt_store_result($stmt); 
        mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika); 
        mysqli_stmt_fetch($stmt);
        if (password_verify($_POST['lozinka'], $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) { 
            $_SESSION['username'] = $imeKorisnika; 
            $_SESSION['level'] = $levelKorisnika; 
            header("Location: administrator.php");
            exit();
        } else { 
            $uspjesnaPrijava = false; 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Martina Rakitić">
    <meta name="keywords" content="vijesti">
    <meta name="description" content="vijesti">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/59f64714b6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Prijava</title>
</head>
<body>
    <header class="d-flex align-items-end">
        <nav class="nav container-fluid">
            <div class="container d-flex align-items-end">
                <img class="logo d-inline-block" src="img/logo.jpg" alt="Logo" />
                <ul class="d-inline-block">
                    <li class="nav-item"><a href="index.php">Naslovnica</a></li>
                    <li><a href="kategorija.php?kategorija=moda" class="">Moda</a></li>
                    <li><a href="kategorija.php?kategorija=parfemi" class="">Parfemi</a></li>
                    <li class="nav-item"><a href="unos.html">Unos</a></li>
                    <li><a href="administrator.php" class="">Administracija</a></li>
                    <li><a href="registracija.php">Registracija</a></li>
                    <li><a href="prijava.php">Prijava</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container main">
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Korisničko ime" required><br>
            <input type="password" name="lozinka" placeholder="Lozinka" required><br>
            <input type="submit" name="prijava" class="slanje" value="Prijava">
        </form>
        <?php
        if (isset($uspjesnaPrijava) && !$uspjesnaPrijava) {
            echo "<p>Neuspješna prijava. Pokušajte ponovo.</p>";
        }
        ?>
    </main>

    <footer class="footer">
        <p>Copyright 2019 GmBh</p>
    </footer>
</body>
</html>
