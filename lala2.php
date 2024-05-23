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
        <section role="main"> 
            <form enctype="multipart/form-data" action="" method="POST"> 
                <div class="form-item"> 
                    <span id="porukaIme" class="bojaPoruke"></span> 
                    <label for="title">Ime: </label> 
                    <div class="form-field"> 
                        <input type="text" name="ime" id="ime" class="form-field-textual"> 
                    </div> 
                </div> 
                <div class="form-item"> 
                    <span id="porukaPrezime" class="bojaPoruke"></span> 
                    <label for="about">Prezime: </label> 
                    <div class="form-field"> 
                        <input type="text" name="prezime" id="prezime" class="form-field-textual"> 
                    </div> 
                </div> 
                <div class="form-item"> 
                    <span id="porukaUsername" class="bojaPoruke"></span> 
                    <label for="content">Korisničko ime:</label> 
                    <?php 
                    $msg = '';
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $ime = $_POST['ime']; 
                        $prezime = $_POST['prezime']; 
                        $username = $_POST['username']; 
                        $lozinka = $_POST['pass']; 
                        $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH); 
                        $razina = 0; 
                        $registriranKorisnik = false; 
                        // Provjera postoji li u bazi već korisnik s tim korisničkim imenom 
                        $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?"; 
                        $stmt = mysqli_stmt_init($dbc); 
                        if (mysqli_stmt_prepare($stmt, $sql)) { 
                            mysqli_stmt_bind_param($stmt, 's', $username); 
                            mysqli_stmt_execute($stmt); 
                            mysqli_stmt_store_result($stmt); 
                        } 
                        if(mysqli_stmt_num_rows($stmt) > 0){ 
                            $msg='Korisničko ime već postoji!'; 
                        } else { 
                            // Ako ne postoji korisnik s tim korisničkim imenom - Registracija korisnika u bazi pazeći na SQL injection 
                            $sql = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)"; 
                            $stmt = mysqli_stmt_init($dbc); 
                            if (mysqli_stmt_prepare($stmt, $sql)) { 
                                mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $username, $hashed_password, $razina); 
                                mysqli_stmt_execute($stmt); 
                                $registriranKorisnik = true; 
                            } 
                        } 
                        mysqli_close($dbc);
                    }
                    }
                    echo '<br><span class="bojaPoruke">'.$msg.'</span>'; 
                    ?> 
                    <div class="form-field"> 
                        <input type="text" name="username" id="username" class="form-field-textual"> 
                    </div> 
                </div> 
                <div class="form-item"> 
                    <span id="porukaPass" class="bojaPoruke"></span> 
                    <label for="pphoto">Lozinka: </label> 
                    <div class="form-field">
                        <input type="password" name="pass" id="pass" class="form-field-textual"> 
                    </div> 
                </div> 
                <div class="form-item"> 
                    <span id="porukaPassRep" class="bojaPoruke"></span> 
                    <label for="pphoto">Ponovite lozinku: </label> 
                    <div class="form-field"> 
                        <input type="password" name="passRep" id="passRep" class="form-field-textual"><br>
                    </div>
                </div> 
                <div class="form-item"> 
                    <button type="submit" value="Prijava" id="slanje">Prijava</button> 
                </div> 
            </form> 
            <?php 
                // Registracija je prošla uspješno 
                if(isset($registriranKorisnik) && $registriranKorisnik == true) { 
                    echo '<p>Korisnik je uspješno registriran!</p>'; 
                } 
            ?> 
        </section> 
        <script type="text/javascript"> 
        document.getElementById("slanje").onclick = function(event) { 
            var slanjeForme = true; 

            var poljeIme = document.getElementById("ime"); 
            var ime = poljeIme.value; 
            if (ime.length == 0) { 
                slanjeForme = false; 
                poljeIme.style.border="1px dashed red"; 
                document.getElementById("porukaIme").innerHTML="<br>Unesite ime!<br>"; 
            } else { 
                poljeIme.style.border="1px solid green"; 
                document.getElementById("porukaIme").innerHTML=""; 
            } 

            var poljePrezime = document.getElementById("prezime"); 
            var prezime = poljePrezime.value; 
            if (prezime.length == 0) { 
                slanjeForme = false;
                poljePrezime.style.border="1px dashed red"; 
                document.getElementById("porukaPrezime").innerHTML="<br>Unesite Prezime!<br>"; 
            } else { 
                poljePrezime.style.border="1px solid green"; 
                document.getElementById("porukaPrezime").innerHTML=""; 
            } 

            var poljeUsername = document.getElementById("username"); 
            var username = poljeUsername.value; 
            if (username.length == 0) { 
                slanjeForme = false; 
                poljeUsername.style.border="1px dashed red"; 
                document.getElementById("porukaUsername").innerHTML="<br>Unesite korisničko ime!<br>"; 
            } else { 
                poljeUsername.style.border="1px solid green"; 
                document.getElementById("porukaUsername").innerHTML=""; 
            } 

            var poljePass = document.getElementById("pass"); 
            var pass = poljePass.value; 
            var poljePassRep = document.getElementById("passRep"); 
            var passRep = poljePassRep.value; 
            if (pass.length == 0 || passRep.length == 0 || pass != passRep) { 
                slanjeForme = false; 
                poljePass.style.border="1px dashed red"; 
                poljePassRep.style.border="1px dashed red"; 
                document.getElementById("porukaPass").innerHTML="<br>Lozinke nisu iste!<br>"; 
                document.getElementById("porukaPassRep").innerHTML="<br>Lozinke nisu iste!<br>"; 
            } else { 
                poljePass.style.border="1px solid green"; 
                poljePassRep.style.border="1px solid green"; 
                document.getElementById("porukaPass").innerHTML=""; 
                document.getElementById("porukaPassRep").innerHTML=""; 
            } 

            if (!slanjeForme) { 
                event.preventDefault(); 
            } 
        }; 
        </script> 
    </main>

    <footer class="footer">
        <p>Copyright 2019 GmBh</p>
    </footer>
</body>
</html>

