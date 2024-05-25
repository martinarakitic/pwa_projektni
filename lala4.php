<?php 
    // Pokaži stranicu ukoliko je korisnik uspješno prijavljen i administrator je 
    if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1) { 
        $query = "SELECT * FROM vijesti"; 
        $result = mysqli_query($dbc, $query); 
        while($row = mysqli_fetch_array($result)) { 
            $query = "SELECT * FROM vijesti"; 
            $result = mysqli_query($dbc, $query); 
            while($row = mysqli_fetch_array($result)) { 
                echo '<form enctype="multipart/form-data" action="" method="POST"> 
                        <div class="form-item"> 
                        <label for="title">Naslov vjesti:</label> 
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
                        <input type="file" class="input-text" id="pphoto" value="'.$row['slika'].'" name="pphoto"/> <br>
                        <img src="' . UPLPATH . $row['slika'] . '" width=100px> // pokraj gumba za odabir slike pojavljuje se umanjeni prikaz postojeće slike 
                        </div> 
                        </div> 
                        <div class="form-item"> 
                        <label for="category">Kategorija vijesti:</label> 
                        <div class="form-field"> 
                        <select name="category" id="" class="form-field-textual" value="'.$row['kategorija'].'"> 
                        <option value="moda">Moda</option> 
                        <option value="parfemi">Parfemi</option> 
                        </select> 
                        </div> 
                        </div> 
                        <div class="form-item"> 
                        <label>Spremiti u arhivu: 
                        <div class="form-field">'; if($row['arhiva'] == 0) { 
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
                $picture = $_FILES['pphoto']['name']; 
                $title=$_POST['title']; 
                $about=$_POST['about']; 
                $content=$_POST['content']; 
                $category=$_POST['category']; 
                if(isset($_POST['archive'])){ 
                    $archive=1; 
                }else{ $archive=0; 
                } 
                $target_dir = 'img/'.$picture; 
                move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir); 
                $id=$_POST['id']; 
                $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content', slika='$picture', kategorija='$category', arhiva='$archive' WHERE id=$id "; 
                $result = mysqli_query($dbc, $query); 
            }
        } // Pokaži poruku da je korisnik uspješno prijavljen, ali nije administrator 
    } else if ($uspjesnaPrijava == true && $admin == false) { 
        echo '<p>Bok ' . $imeKorisnika . '! Uspješno ste prijavljeni, ali niste administrator.</p>'; 
    } else if (isset($_SESSION['$username']) && $_SESSION['$level'] == 0) {
        echo '<p>Bok ' . $_SESSION['$username'] . '! Uspješno ste prijavljeni, ali niste administrator.</p>'; 
        } else if ($uspjesnaPrijava == false) { 
?> 
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
<?php } ?>