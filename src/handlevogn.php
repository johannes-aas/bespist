<?php
    session_start();

    $tilkobling = mysqli_connect("localhost","root","","bespist");

    if (empty($_SESSION['handlevogn'])) {
        $_SESSION['handlevogn'] = array();
    }

    if (isset($_POST['slett'])) {
        $rett = $_POST['rett'];

        unset($_SESSION['handlevogn'][$rett]);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bespist</title>
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
                        <li><img src="bilder/hvit_logo.png"></img></li>
                        <a href="index.php"><li class="navHover">HJEM</li></a>
                        <a href="meny.php"><li class="navHover">MENY</li></a>
                        <a href="kontakt.php"><li class="navHover">KONTAKT</li></a>
                        <a><li id="aktiv">HANDLEVOGN</li></a>
                    </ul>
                </nav>
            </header>
            <div id="backgroundHeader" style="background-image: url('bilder/restaurant.jpg');"></div>
            <main>
                <?php
                    if (isset($_GET['bestilling'])) {
                        if ($_GET['bestilling'] == "fullført") {
                ?>
                            <div class="brukerMelding">
                                <p>Bestillingen er registrert</p>
                            </div>
                <?php
                        }
                    }
                ?>
                <div class="boks" id="handlevogn">
                <?php
                    $sum = 0;

                    if (count($_SESSION['handlevogn']) > 0) { ?>
                        <table>
                            <tr>
                                <th>Matrett</th>
                                <th>Antall</th>
                                <th>Pris</th>
                                <th>Total</th>
                            </tr>
                <?php
                        foreach ($_SESSION['handlevogn'] as $rettid => $antall) {

                            $sql = "SELECT rettnavn, pris FROM rett WHERE rettid='$rettid'";
                            $datasett = $tilkobling->query($sql);

                            while($rad = mysqli_fetch_array($datasett)) {
                ?>
                                <tr>
                                    <td class="tabellRettnavn"><?php echo $rad['rettnavn']; ?></td>
                                    <td class="tabellAntall"><?php echo $antall; ?></td>
                                    <td class="tabellPris"><?php echo $rad['pris']; ?>,-</td>
                                    <td class="tabellTotal"><?php $total = $rad['pris'] * $antall; echo $total; ?>,-</td>
                                    <td class="slett">
                                        <form action="handlevogn.php" method="post">
                                            <input hidden name="rett" value="<?php echo $rettid ?>">
                                            <button type="submit" name="slett">&times;</button>
                                        </form>
                                    </td>
                                </tr>
                <?php
                                $sum += $total;
                            }
                        }
                ?>
                        <tr>
                            <td colspan="3"></td>
                            <td class="sum"><?php echo $sum; ?> kr</td>
                        </tr>
                    </table>
                <?php
                    } else {
                        echo "<h2 style='padding: 20px;'>Handlevognen er tom. Gå til <a href='meny.php'>menyen</a> for å finne varer.</h2>";
                    }
                ?>
                </div>
                <?php
                    if ($sum > 0) {
                ?>
                        <div id="handlevognKnapper" class="boks">
                            <a id="handle" href="meny.php">
                                <svg width="20" height="20">
                                    <polygon points="15,0 0,10 15,20" fill="black" />
                                </svg>
                                <span>Fortsett å handle</span>
                            </a>
                <?php
                        if (isset($_SESSION['brukerid'])) {
                ?>
                            <form id="bestill" action="bestilling.php" method="post">
                                <button type="submit">Fullfør bestilling</button>
                            </form>
                <?php
                        } else {
                ?>
                            <div id="bruker">
                                <p>Du trenger en bruker for å fullføre bestillingen</p>
                                <a style="float: left" href="login.php">Logg inn</a>
                                <a style="float: right" href="registrer.php">Registrer ny bruker</a>
                                <br style="clear: both">
                            </div>
                <?php
                        }
                ?>
                        </div>
                <?php
                    }
                ?>
            </main>
            <footer>
                <p>&copy; <?php echo date('Y'); ?> Johannes Hansen Aas</p>
            </footer>
        </div>
        <script>

            $('.brukerMelding').fadeIn();

            setTimeout(function() {
                $('.brukerMelding').fadeOut();
            }, 2000);

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
