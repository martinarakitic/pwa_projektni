<?php 
    include 'connect.php'; 
    define('UPLPATH', 'img/'); 
    if (!$dbc) {
        die("Povezivanje nije uspjelo: " . mysqli_connect_error());
    }

    // Dohvati ID članka iz URL parametara
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($dbc, $_GET['id']);
    } else {
        die("Članak nije specificiran.");
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
    <title>Članak</title>
</head>
<body>
    <header class="d-flex align-items-end">
        <nav class="nav container-fluid">
            <div class="container d-flex align-items-end">
                <img class="logo d-inline-block" src="img/logo.jpg" alt="Logo" />
                <ul class="d-inline-block">
                    <li class="nav-item"><a href="index.php">Početna</a></li>
                    <li><a href="kategorija.php?kategorija=moda" class="">Moda</a></li>
                    <li><a href="kategorija.php?kategorija=parfemi" class="">Parfemi</a></li>
                    <li class="nav-item"><a href="unos.html">Unos</a></li>
                    <li><a href="administrator.php" class="">Administracija</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="container main">
        <section role="main"> 
            <?php 
                $query = "SELECT * FROM vijesti WHERE id='$id'";
                $result = mysqli_query($dbc, $query); 

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo '<div class="row">';
 //                   echo '<h2 class="category"><span>' . $row['kategorija'] . '</span></h2>'; 
                    echo '<div class="naslov"><h1>' . $row['naslov'] . '</h1></div>'; 
                    echo '<p class="datum"> <span>' . $row['datum'] . '</span></p>'; 
                    echo '<section class="slika"><img src="' . UPLPATH . $row['slika'] . '"></section>'; 
                    
                    echo '<section class="about"><p><i>' . $row['sazetak'] . '</i></p></section>'; 
                    echo '<section class="sadrzaj"><p>' . $row['tekst'] . '</p></section>'; 
                    echo '</div>';
                } else {
                    echo "Članak nije pronađen.";
                }
            ?>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2019 GmBh</p>
    </footer>
</body>
</html>
