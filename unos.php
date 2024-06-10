<?php 
    include 'connect.php'; 
    $picture = $_FILES['pphoto']['name']; 
    $title=$_POST['title']; 
    $about=$_POST['about']; 
    $content=$_POST['content']; 
    $category=$_POST['category']; 
    $date=date('d.m.Y.'); 
    if(isset($_POST['archive'])){ 
        $archive=1; 
        }else { 
            $archive=0; 
        } 
    $target_dir = 'img/'.$picture; 
    move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir); 
    $query = "INSERT INTO Vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva ) 
    VALUES ('$date', '$title', '$about', '$content', '$picture', '$category', '$archive')"; 
    $result = mysqli_query($dbc, $query) or die('Error querying databese.'); 
    mysqli_close($dbc); 
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

    
    <main>
        <section class="container d-flex justify-content-center align-items-center usnos_forma">
            <form enctype="multipart/form-data" action="unos.php" method="POST" class="form"> 
                <div class="form-item"> 
                    <span id="porukaTitle" class="bojaPoruke"></span> 
                    <label for="title">Naslov vijesti</label> 
                    <div class="form-field"> 
                        <input type="text" name="title" id="title" class="form-field-textual"> 
                    </div> 
                </div> 
                <div class="form-item"> 
                    <span id="porukaAbout" class="bojaPoruke"></span> 
                    <label for="about">Kratki sadržaj vjesti (do 50 znakova)</label> 
                    <div class="form-field"> 
                        <textarea name="about" id="about" cols="30" rows="10" class="form-field-textual"></textarea> 
                    </div> 
                </div> 
                <div class="form-item"> 
                    <span id="porukaContent" class="bojaPoruke"></span> 
                    <label for="content">Sadržaj vjesti</label> 
                    <div class="form-field"> 
                        <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual"></textarea> 
                    </div> 
                </div> 
                <div class="form-item"> 
                    <span id="porukaSlika" class="bojaPoruke"></span> 
                    <label for="pphoto">Slika: </label> 
                    <div class="form-field"> 
                        <input type="file" class="input-text" id="pphoto" name="pphoto"/> 
                    </div> 
                </div> 
                <div class="form-item"> 
                    <span id="porukaKategorija" class="bojaPoruke"></span> 
                    <label for="category">Kategorija vjesti</label> 
                    <div class="form-field"> 
                        <select name="category" id="category" class="form-field-textual"> 
                            <option value="" disabled selected>Odabir kategorije</option>
                            <option value="moda">Moda</option> 
                            <option value="parfemi">Parfemi</option> 
                        </select> 
                    </div> 
                </div> 
                <div class="form-item"> 
                    <label>Spremiti u arhivu: 
                        <div class="form-field"> 
                            <input type="checkbox" name="archive" id="archive"> 
                        </div> 
                    </label> 
                </div> 
                <div class="form-item"> 
                    <button type="reset" value="Poništi" class="ponisti">Poništi</button> 
                    <button type="submit" value="Prihvati" id="slanje" class="slanje">Prihvati</button> 
                </div> 
            </form>
        </section>
    </main>

    <h3>Vijest unešena.</h3>

    <footer class="footer">
        <p>Copyright 2019 GmBh</p>
    </footer>
</body>
</html>
