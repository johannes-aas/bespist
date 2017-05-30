<?php
    session_start();

    $tilkobling = mysqli_connect("localhost","root","","bespist");

    $brukerid = $_SESSION['brukerid'];

    if (!isset($_SESSION['brukerid'])) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Min side</title>
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
                            echo "<a><li>MIN SIDE</li></a>";
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
                        <a href='index.php'><li class="navHover">HJEM</li></a>
                        <a href="meny.php"><li class="navHover">MENY</li></a>
                        <a href="kontakt.php"><li class="navHover">KONTAKT</li></a>
                        <a href="handlevogn.php"><li class="navHover">HANDLEVOGN</li></a>
                    </ul>
                </nav>
            </header>
            <div id="backgroundHeader" style="background-image: url('bilder/restaurant.jpg');"></div>
            <main>
                <?php
                    $sql = "SELECT * FROM bruker WHERE brukerid='$brukerid'";
                    $datasett = $tilkobling->query($sql);
                    $rad = mysqli_fetch_array($datasett);
                ?>
                <h1>Velkommen, <?php echo $rad['brukernavn']; ?>!</h1>
                <h2>Min profil:</h2>
                <div class="boks">
                    <p><strong>Navn:</strong> <?php echo $rad['fornavn']." ".$rad['etternavn']; ?></p>
                    <p><strong>Adresse:</strong> <?php echo $rad['adresse'] ?></p>
                </div>
                <?php
                    $sql = "SELECT ordrenummer, ordretidspunkt, brukerid FROM ordre WHERE brukerid='$brukerid'";
                    $datasett = $tilkobling->query($sql);

                    if (mysqli_num_rows($datasett) == 0) {
                        echo "<h2>Du har ingen bestillinger.</h2>";
                    } else {
                        echo "<h2>Mine bestillinger:</h2>";
                        while($rad = mysqli_fetch_array($datasett)) {
                ?>
                            <div class="boks">
                                <h2><?php echo $rad['ordretidspunkt']; ?></h2>
                                <table>
                                    <tr>
                                        <th>Rett</th>
                                        <th>Antall</th>
                                        <th>Pris</th>
                                        <th>Total</th>
                                    </tr>
                                    <?php
                                        $sql = "SELECT ordrenummer, antall, rettnavn, pris FROM ordrelinje, rett WHERE rett.rettid = ordrelinje.rettid AND ordrenummer='".$rad['ordrenummer']."'";
                                        $datasett2 = $tilkobling->query($sql);

                                        $sum = 0;

                                        while($rad2 = mysqli_fetch_array($datasett2)) {

                                            $antall = $rad2['antall'];
                                            $pris = $rad2['pris'];
                                    ?>
                                            <tr>
                                                <td class="tabellRettnavn"><?php echo $rad2['rettnavn']; ?></td>
                                                <td class="tabellAntall"><?php echo $antall; ?></td>
                                                <td class="tabellPris"><?php echo $pris; ?>,-</td>
                                                <td class="tabellTotal"><?php $total = $pris * $antall; echo $total; ?>,-</td>
                                            </tr>
                                    <?php
                                            $sum += $total;
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="sum"><?php echo $sum; ?> kr</td>
                                    </tr>
                                </table>
                            </div>
                    <?php
                        }
                    }

                    $sql = "SELECT brukernavn, admin FROM bruker WHERE brukerid='$brukerid'";
                    $datasett = $tilkobling->query($sql);
                ?>
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
