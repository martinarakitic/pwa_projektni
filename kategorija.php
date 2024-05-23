<?php 
include 'connect.php'; 
define('UPLPATH', 'img/'); 
if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Martina Rakitić">
    <meta name="keywords" content="news">
    <meta name="description" content="news">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/59f64714b6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Home</title>
</head>
<body>
    <header class="d-flex align-items-end">
        <nav class="nav container-fluid">
            <div class="container d-flex align-items-end">
                <img class="logo d-inline-block" src="img/logo.jpg" alt="Logo" />
                <ul class="d-inline-block">
                    <li class="nav-item"><a href="index.php">Home</a></li>
                    <li><a href="kategorija.php?kategorija=moda" class="">Moda</a></li>
                    <li><a href="kategorija.php?kategorija=parfemi" class="">Parfemi</a></li>
                    <li class="nav-item"><a href="unos.html">Unos</a></li>
                    <li><a href="administrator.php" class="">Administracija</a></li>
                    <li><a href="registracija.php">Registracija</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container main">
        <section class="moda">
            <h2>Moda</h2>
            <hr>
            <div class="row">
            <?php 
                if (isset($_GET['kategorija'])) {
                    $kategorija = mysqli_real_escape_string($dbc, $_GET['kategorija']);
                    
                    $query = "SELECT * FROM vijesti WHERE kategorija='$kategorija'";
                    $result = mysqli_query($dbc, $query); 
                    if (!$result) {
                        die("Query failed: " . mysqli_error($dbc));
                    }
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) { 
                            echo '<article class="col-lg-4 col-sm-4">'; 
                            echo '<div class="article">'; 
                            echo '<div class="moda_img">'; 
                            echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '">'; 
                            echo '</div>'; 
                            echo '<div class="media_body">'; 
                            echo '<h4 class="title">'; 
                            echo '<a href="clanak.php?id=' . $row['id'] . '">'; 
                            echo $row['naslov']; 
                            echo '</a></h4>'; 
                            echo '</div></div>'; 
                            echo '</article>'; 
                        }
                    } else {
                        echo "Nema vijesti u kategoriji " . htmlspecialchars($kategorija) . ".";
                    }
                } else {
                    echo "Kategorija nije odabrana.";
                }
            ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2019 GmBh</p>
    </footer>
</body>
</html>
