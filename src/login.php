<?php
    session_start();

    if (isset($_SESSION['brukerid'])) {
        header("Location: index.php");
        exit();
    }

    $brukernavn = $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $brukernavn = $_POST['brukernavn'];
        $passord = $_POST['passord'];

        $tilkobling = mysqli_connect("localhost","root","","bespist");
        $sql = "SELECT brukerid, brukernavn, passord FROM bruker WHERE brukernavn='$brukernavn' AND passord='$passord'";
        $datasett = $tilkobling->query($sql);

        if(!$rad = $datasett->fetch_assoc()) {
            $error = "Feil brukernavn eller passord!";
        } else {
            $_SESSION['brukerid'] = $rad['brukerid'];
            header("Location: min_side.php");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Logg inn</title>
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
                            echo "<a href='registrer.php'><li>REGISTRER</li></a>";
                            echo "<a><li>LOGG INN</li></a>";
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
                        <li><img src="bilder/hvit_logo.png"></img></li>
                        <a href="index.php"><li class="navHover">HJEM</li></a>
                        <a href="meny.php"><li class="navHover">MENY</li></a>
                        <a href="kontakt.php"><li class="navHover">KONTAKT</li></a>
                        <a href="handlevogn.php"><li class="navHover">HANDLEVOGN</li></a>
                    </ul>
                </nav>
            </header>
            <div id="backgroundHeader" style="background-image: url('bilder/restaurant.jpg');"></div>
            <main>
                <form id="login" action="login.php" method="POST">
                    <input type="text" name="brukernavn" placeholder="Brukernavn" value="<?php echo $brukernavn ?>">
                    <input type="password" name="passord" placeholder="Passord">
                    <button type="submit">Logg inn</button>
                    <p id="error"><?php echo $error; ?></p>
                    <p style="padding: 20px; font-size: 20px;">Magler du en bruker? <a href="registrer.php">Registrer</a></p>
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
                    $('.mainHeader img').css('clip', 'rect(0px, 186px, 54px, 0px)');
                    $('.mainHeader img').css('padding', '0 10px');
                    $('#brukerNav ul').slideUp();
                } else {
                    $('.mainHeader').css('background-color', 'rgba(0, 0, 0, 0.5)');
                    $('.mainHeader nav a').css('padding', '75px 0 70px 0');
                    $('.mainHeader img').css('clip', 'rect(0px, 186px, 195px, 0px)');
                    $('.mainHeader img').css('padding', '10px');
                    $('#brukerNav ul').slideDown();
                }
            });
        </script>
    </body>
</html>
