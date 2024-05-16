<?php 
    if (isset($_POST['category']) && isset($_POST['title']) && isset($_POST['pphoto']) && isset($_POST['about']) && isset($_POST['content'])) {
        $category = $_POST['category'];
        $title = $_POST['title'];
        $image = $_POST['pphoto'];
        $about = $_POST['about'];
        $content = $_POST['content'];
    }

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
    <title>Članak</title>
</head>
<body class="clanak">
    <header class=" d-flex align-items-end">
            <nav class="nav container-fluid ">  
                <div class="container d-flex align-items-end">
                <img class="logo d-inline-block" src="img/logo.jpg" alt="Logo" />
                
                    <ul class="d-inline-block ">
                        <li class="nav-item"><a href="index.html">Home</a></li>
                        <li class="nav-item"><a href="#">Reise</a></li>
                        <li class="nav-item"><a href="#">VERBRAUCHER</a></li>
                        <li class="nav-item"><a href="unos.html">Unos</a></li>
                        <li class="nav-item"><a href="#" >Administracija</a></li>

                    </ul>
            </div>
            </nav>
    </header>

    <main class="container tijelo_clanka">
        <div class="row"> 
        <!--    <p class="category"> <?php echo $category; ?></p> -->
                 <h1 class="title"><?php echo $title; ?></h1> 
        </div> 
        <div class="row"> 
            <section class="datum"> <?php echo date('d.m.Y')?></section>
        </div>
            <section class="slika"> <?php echo "<img src='img/$image'"; ?> </section> 
          <!--  <section class="about"> <p> <?php echo $about; ?> </p> </section> -->
            <section class="sadrzaj"> <p> <?php echo $content; ?> </p>        
    </main>
    
    <footer class="footer">
        <p>Copyright 2019 GmBh</p>
    </footer>
</body>
</html>