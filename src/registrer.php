<?php
    session_start();

    if (isset($_SESSION['brukerid'])) {
        header("Location: index.php");
        exit();
    }

    $tilkobling = mysqli_connect("localhost","root","","bespist");

    $error = 0;
    $error_fornavn = $error_etternavn = $error_adresse = $error_brukernavn = $error_passord = $error_brukernavnibruk = $error_ulikepassord = "";
    $fornavn = $etternavn = $adresse = $brukernavn = $passord = $bekreft_passord = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $fornavn = $_POST['fornavn'];
        $etternavn = $_POST['etternavn'];
        $adresse = $_POST['adresse'];
        $brukernavn = $_POST['brukernavn'];
        $passord = $_POST['passord'];
        $bekreft_passord = $_POST['bekreft_passord'];

        $sql = "SELECT brukernavn FROM bruker WHERE brukernavn='$brukernavn'";
        $datasett = $tilkobling->query($sql);
        $brukernavncheck = mysqli_num_rows($datasett);

        if (empty($fornavn)) {
            $error_fornavn = "Mangler fornavn";
            $error = 1;
        }
        else if (empty($etternavn)) {
            $error_etternavn = "Mangler etternavn";
            $error = 1;
        }
        else if (empty($adresse)) {
            $error_adresse = "Mangler adresse";
            $error = 1;
        }
        else if (empty($brukernavn)) {
            $error_brukernavn = "Mangler brukernavn";
            $error = 1;
        }
        else if (empty($passord)) {
            $error_passord = "Mangler passord";
            $error = 1;
        }

        else if ($brukernavncheck > 0) {
            $error_brukernavnibruk = "Brukernavn er opptatt";
            $error = 1;
        }
        else if ($passord != $bekreft_passord) {
            $error_ulikepassord = "Passordene er ikke like";
            $error = 1;
            $passord = $bekreft_passord = "";
        }

        if ($error == 0) {
            $sql = "INSERT INTO bruker (fornavn, etternavn, adresse, brukernavn, passord, admin)
            VALUES ('$fornavn','$etternavn','$adresse','$brukernavn','$passord',FALSE)";
            $datasett = $tilkobling->query($sql);

            $_SESSION['brukernavn'] = $brukernavn;
            $_SESSION['passord'] = $passord;

            header("Location: loginScript.php");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registrer</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="main.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <link rel="icon" href="bilder/">
    </head>
    <body>
        <div id="mainWrapper">
            <nav id="brukerNav">
                <ul>
                    <?php
                        if (isset($_SESSION['brukerid'])) {
                            echo "<a href='logout.php'><li>LOGG UT</li></a>";
                            echo "<a href='min_side.php'><li>MIN SIDE</li></a>";
                        } else {
                            echo "<a><li>REGISTRER</li></a>";
                            echo "<a href='login.php'><li>LOGG INN</li></a>";
                        }
                    ?>
                </ul>
                <div id="brukerNav_knapp">
                    <span>BRUKER</span>
                    <svg width="40" height="20">
                        <polygon points="10,5 40,5 25,20" fill="white" />
                    </svg>
                </div>
            </nav>
            <header class="mainHeader">
                <nav>
                    <ul>
                        <a href="index.php"><li class="navHover">HJEM</li></a>
                        <a href="meny.php"><li class="navHover">MENY</li></a>
                        <a href="kontakt.php"><li class="navHover">KONTAKT</li></a>
                        <a href="handlevogn.php"><li class="navHover">HANDLEVOGN</li></a>
                    </ul>
                </nav>
            </header>
            <div id="backgroundHeader" style="background-image: url('bilder/restaurant.jpg');"></div>
            <main>
                <form id="registrer" action="registrer.php" method="POST">
                    <input type="text" name="fornavn" placeholder="Fornavn" value="<?php echo $fornavn; ?>">
                    <input type="text" name="etternavn" placeholder="Etternavn" value="<?php echo $etternavn; ?>">
                    <input type="text" name="adresse" placeholder="Adresse" value="<?php echo $adresse; ?>">
                    <input type="text" name="brukernavn" placeholder="Brukernavn" value="<?php echo $brukernavn; ?>">
                    <input type="password" name="passord" placeholder="Passord" value="<?php echo $passord; ?>">
                    <input type="password" name="bekreft_passord" placeholder="Bekreft passord" value="<?php echo $bekreft_passord; ?>">
                    <button type="submit">Registrer</button>
                    <p id="error">
                        <?php
                            echo $error_fornavn;
                            echo $error_etternavn;
                            echo $error_adresse;
                            echo $error_brukernavn;
                            echo $error_brukernavnibruk;
                            echo $error_passord;
                            echo $error_ulikepassord;
                        ?>
                    </p>
                    <p style="padding: 20px; font-size: 20px;">Har du allerede en bruker? <a href="login.php">Logg inn</a></p>
                </form>
            </main>
            <footer>
                <p>&copy; <?php echo date('Y'); ?> Johannes Hansen Aas</p>
            </footer>
        </div>
        <script>
            function brukerNav_Toggle() {
                $('#brukerNav ul').slideToggle();
            }

            $('#brukerNav_knapp').click(function() {
                brukerNav_Toggle();
            });

            $(window).scroll(function() {
                if($(window).scrollTop() > 10) {
                    $('.mainHeader').css('background-color', '#333');
                    $('.mainHeader nav a').css('padding', '0');
                } else {
                    $('.mainHeader').css('background-color', 'rgba(0, 0, 0, 0.5)');
                    $('.mainHeader nav a').css('padding', '75px 0 70px 0');
                }
            });
        </script>
    </body>
</html>
