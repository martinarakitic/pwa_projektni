<?php 
    include 'connect.php'; 
    define('UPLPATH', 'img/'); 
?>
<!DOCTYPE html>
<html lang="en">
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
    <header class=" d-flex align-items-end">
            <nav class="nav container-fluid ">  
                <div class="container d-flex align-items-end">
                <img class="logo d-inline-block" src="img/logo.jpg" alt="Logo" />
                
                    <ul class="d-inline-block ">
                        <li class="nav-item"><a href="#">Home</a></li>
                       <li><a href="kategorija.php?id=moda" class="">Moda</a></li>
                       <li><a href="kategorija.php?id=parfemi" class="">Parfemi</a></li>                    
                        <li class="nav-item"><a href="unos.html">Unos</a></li>
                        <li> <a href="administracija.php" class="">Administracija</a> </li>
                    </ul>
            </div>
            </nav>
    </header>

    <main class="container">
        <section  class="moda">
            <h2>Moda</h2>
            <?php 
                $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='moda' LIMIT 6"; 
                $result = mysqli_query($dbc, $query); 
                $i=0; 
                while($row = mysqli_fetch_array($result)) { 
                    echo '<article>'; 
                    echo'<div class="article">'; 
                    echo '<div class="moda_img">'; 
                    echo '<img src="' . UPLPATH . $row['slika'] . '"'; 
                    echo '</div>'; echo '<div class="media_body">'; 
                    echo '<h4 class="title">'; 
                    echo '<a href="clanak.php?id='.$row['id'].'">'; 
                    echo $row['naslov']; 
                    echo '</a></h4>'; 
                    echo '</div></div>'; 
                    echo '</article>'; 
                }
            ?>
        </section>

        <section class="parfemi">

        </section>

    </main>

    <footer class="footer">
        <p>Copyright 2019 GmBh</p>
    </footer>
</body>
</html>