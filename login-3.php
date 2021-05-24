<?php

    session_start ();
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
    
    include 'XML_baza_load.php';
    
    setlocale(LC_ALL,'croatian'); 
    $datum = ucwords (iconv('ISO-8859-2', 'UTF-8',strftime('%A, %d %B')));
    


    if (isset($_POST['sifra']))
    {   
        $e_mail = $_POST['email'];
        $sifra = $_POST['sifra'];
    
        // PROVJERA XML BAZE //
    
        foreach ($korisniciXML->Korisnik as $user)
        {
            $xml_id = $user->id;
            $xml_ime_kor = $user->ime_korisnika;
            $xml_prez_kor = $user->prezime_korisnika;
            $xml_email_kor = $user->email_korisnika;
            $xml_user_kor = $user->username_korisnika;
            $xml_sifra_kor = $user->sifra_korisnika;
            if ($e_mail == $xml_email_kor)
            {
                $_SESSION['email_dobar'] = 1;
                if ($sifra == $xml_sifra_kor)
                { 
                    
                    $_SESSION['id'] = $xml_id;
                    $_SESSION['username'] = $xml_user_kor; 
                    #unset($_SESSION['kriva_lozinka']);
                    #unset($_SESSION['krivi_email']);
                    #header("Location:login.php");
                }
                else 
                {
                    $_SESSION['kriva_lozinka'] = 1;
                }
            }
        }
        
        if ($_SESSION['email_dobar'] == 1)
        {
            #unset($_SESSION['email_dobar']);
            #header("Location:login.php");
        }
        else
        {
            $_SESSION['krivi_email'] = 1;
            #unset($_SESSION['kriva_lozinka']);
            #header("Location:login.php");
        }
        
    }
    
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>BMK</title>
    <meta charset="UTF-8"/>
    <meta name="author" content="Matija Đurekovec"/>
    <meta http-equiv="content-language" content="hr"/>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="icon" href="img/bmk-logo-fav.png" type="image/x-icon">
</head>
<body>
    <header>
        <div id="center">
            <nav>
                <ul>
                    <li><a href="index.php"><img src="img/bmk-logo.png"></a></li>
                    <li class="lista_polozaj"><a href="index.php">Početna</a></li>
                    <li class="lista_polozaj"><a href="vijesti.php">Vijesti</a></li>
                    <li class="lista_polozaj"><a href="unos.php">Unos vijesti</a></li>
                    <li class="lista_polozaj"><a href="administracija.php">Administracija</a></li>
                    <li class="lista_polozaj"><a href="about.php">O nama</a></li>
                </ul>
                <ul id="prijava_registracija">
                    <?php
                    
                        if (isset($_SESSION['username']))
                        {
                            echo '
                                <li><a href="">' .$_SESSION['username']. '</a></li>
                                <li><a href="logout.php">Odjava</a></li>
                            ';
                        }
                        else
                        {
                            echo '
                                <li><a href="login.php">Prijava</a></li>
                                <li><a href="register.php">Registracija</a></li>
                            ';
                        }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
    <main id="login">
        <div id="center">
            <?php
                if (isset($_SESSION['id']))
                {
                    echo '
                        <p class="prijava_tekst">
                        Prijavljeni ste kao: <b>' .$_SESSION['username']. '</b>
                        </p>
                        <form method="POST" action="logout.php">
                            <br>
                            <input type="submit" value="Odjava" id="reset_submit">
                        </form>';
                }
                else
                {
                    if (isset($_SESSION['krivi_email']))
                    {
                        echo '<p class="prijava_error">';
                        echo '<b>Krivi e-mail !';
                        echo '<br>Pokušajte ponovo</b><br><br></p>';
                        unset($_SESSION['krivi_email']);
                    }
                    else if (isset($_SESSION['kriva_lozinka']))
                    {
                        echo '<p class="prijava_error">';
                        echo '<b>Kriva lozinka!';
                        echo '<br>Pokušajte ponovo</b><br><br></p>';
                        unset($_SESSION['kriva_lozinka']);
                    } else {
                        
                        echo '
                        <form method="POST" action="login.php">
                            <label for="email">E-mail</label><br>
                            <input type="email" name="email" required><br><br>
                            <label for="sifra">Lozinka</label><br>
                            <input type="password" name="sifra" required><br><br>
                            <input type="submit" value="Prijava" id="reset_submit">
                            <input type="reset" value="Poništi" id="reset_submit">
                        </form>';
                    }
                    
                }
            ?>
        </div>
    </main>
    <footer>
        <div id="center">
            <p>Stranicu napravio: Matija Đurekovec</p>
            <p>E-mail: mdurekove@tvz.hr</p>
            <b><p>Copyright © 2021 BMK.</p></b>
        </div>
    </footer>
</body>
</html>

