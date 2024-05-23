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
    <title>Naslovnica</title>
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
                </ul>
            </div>
        </nav>
    </header>

    <?php 
        session_start(); 
        include 'connect.php'; 
        define('UPLPATH', 'img/'); 
        if(isset($_SESSION['username']) && $_SESSION['level'] == 1) {
            // Korisnik je već prijavljen kao administrator
            // Prikaži formu za administraciju
        } else if(isset($_SESSION['username'])) {
            // Korisnik je već prijavljen, ali nije administrator
            echo '<p>Bok ' . htmlspecialchars($_SESSION['username']) . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
        } else if (isset($_POST['prijava'])) { 
            // Provjeri korisničke pristupne podatke
            $prijavaImeKorisnika = $_POST['username']; 
            $prijavaLozinkaKorisnika = $_POST['lozinka']; 
            $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
            $stmt = mysqli_stmt_init($dbc); 
            if (mysqli_stmt_prepare($stmt, $sql)) { 
                mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika); 
                mysqli_stmt_execute($stmt); 
                mysqli_stmt_store_result($stmt); 
            } 
            mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika); 
            mysqli_stmt_fetch($stmt); 
            //Provjera lozinke 
            if (password_verify($prijavaLozinkaKorisnika, $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) { 
                $_SESSION['username'] = $imeKorisnika; 
                $_SESSION['level'] = $levelKorisnika; 
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            } else { 
                echo "<p>Pogrešno korisničko ime ili lozinka!</p>"; 
            } 
        } 
    ?>

    <?php if (!isset($_SESSION['username']) || $_SESSION['level'] != 1) { ?>
        <!-- Forma za prijavu -->
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Korisničko ime" required><br>
            <input type="password" name="lozinka" placeholder="Lozinka" required><br>
            <input type="submit" name="prijava" value="Prijava">
        </form>
    <?php } ?>

    <main class="container main">
    <?php 
            $query = "SELECT * FROM vijesti"; 
            $result = mysqli_query($dbc, $query); 
            while($row = mysqli_fetch_array($result)) { 
                echo '<form enctype="multipart/form-data" action="" method="POST"> 
                        <div class="form-item"> 
                        <label for="title">Naslov vijesti:</label> 
                        <div class="form-field"> 
                        <input type="text" name="title" class="form-field-textual" value="'.$row['naslov'].'"> 
                        </div> 
                        </div> 
                        <div class="form-item"> 
                        <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label> 
                        <div class="form-field"> 
                        <textarea name="about" id="" cols="30" rows="10" class="form-field-textual">'.$row['sazetak'].'</textarea> 
                        </div> 
                        </div> 
                        <div class="form-item"> 
                        <label for="content">Sadržaj vijesti:</label> 
                        <div class="form-field"> 
                        <textarea name="content" id="" cols="30" rows="10" class="form-field-textual">'.$row['tekst'].'</textarea> 
                        </div> 
                        </div> 
                        <div class="form-item"> 
                        <label for="pphoto">Slika:</label> 
                        <div class="form-field">
                        <input type="file" class="input-text" id="pphoto" name="pphoto"/> <br>
                        <img src="' . UPLPATH . $row['slika'] . '" width=100px> <!-- pokraj gumba za odabir slike pojavljuje se umanjeni prikaz postojeće slike -->
                        </div> 
                        </div> 
                        <div class="form-item"> 
                        <label for="category">Kategorija vijesti:</label> 
                        <div class="form-field"> 
                        <select name="category" id="" class="form-field-textual" value="'.$row['kategorija'].'"> 
                        <option value="moda"'.($row['kategorija'] == 'moda' ? ' selected' : '').'>Moda</option> 
                        <option value="parfemi"'.($row['kategorija'] == 'parfemi' ? ' selected' : '').'>Parfemi</option> 
                        </select> 
                        </div> 
                        </div> 
                        <div class="form-item"> 
                        <label>Spremiti u arhivu: 
                        <div class="form-field">'; 
                        if($row['arhiva'] == 0) { 
                            echo '<input type="checkbox" name="archive" id="archive"/> Arhiviraj?'; 
                        } else { 
                            echo '<input type="checkbox" name="archive" id="archive" checked/> Arhiviraj?'; 
                        } 
                        echo '</div> </label> </div> </div> 
                        <div class="form-item"> 
                        <input type="hidden" name="id" class="form-field-textual" value="'.$row['id'].'"> 
                        <button type="reset" value="Poništi">Poništi</button> 
                        <button type="submit" name="update" value="Prihvati"> Izmjeni</button> 
                        <button type="submit" name="delete" value="Izbriši"> Izbriši</button> 
                        </div> 
                        </form>'; 
                    }
            if(isset($_POST['delete'])){ 
                $id=$_POST['id']; 
                $query = "DELETE FROM vijesti WHERE id=$id "; 
                $result = mysqli_query($dbc, $query); 
            }
            if(isset($_POST['update'])){ 
                if(isset($_POST['update'])){
                    $id=$_POST['id'];
                    $title=$_POST['title'];
                    $about=$_POST['about'];
                    $content=$_POST['content'];
                    $category=$_POST['category'];
                    if(isset($_POST['archive'])){
                        $archive=1;
                    }else{
                        $archive=0;
                    }
                    
                    // Provjeri je li prenesena nova slika
                    if (!empty($_FILES['pphoto']['name'])) {
                        // Ako je nova slika prenešena, izvrši prijenos slike
                        $picture = $_FILES['pphoto']['name'];
                        $target_dir = 'img/'.$picture;
                        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
                    } else {
                        // Ako nova slika nije prenešena, zadrži staru sliku
                        $query = "SELECT slika FROM vijesti WHERE id=$id";
                        $result = mysqli_query($dbc, $query);
                        $row = mysqli_fetch_assoc($result);
                        $picture = $row['slika'];
                    }
                
                    $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content', slika='$picture', kategorija='$category', arhiva='$archive' WHERE id=$id ";
                    $result = mysqli_query($dbc, $query);
                }}
                
        ?>
    </main>

    <footer class="footer">
        <p>&copy; 2019 GmBh</p>
    </footer>
</body>
</html>
