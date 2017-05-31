<?php
    session_start();

    $tilkobling = mysqli_connect("localhost","root","","bespist");

    $handlevogn_melding = "";

    if (empty($_SESSION['handlevogn'])) {
        $_SESSION['handlevogn'] = array();
    }

    if (isset($_POST['legg_i_handlevogn'])) {

        $rettid = $_POST['rettid'];
        $antall = $_POST['antall'];
        $kategori = $_POST['kategori'];

        $_SESSION['handlevogn'][$rettid] = $antall;

        $get_handlevogn_status = "&handlevogn=oppdatert";
        $get_kategori_status = "?kategori=$kategori";

        header("Location: " . $_SERVER['REQUEST_URI'].$get_kategori_status.$get_handlevogn_status);
        exit();
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Meny</title>
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
                        <a><li id="aktiv">MENY</li></a>
                        <a href="kontakt.php"><li class="navHover">KONTAKT</li></a>
                        <a href="handlevogn.php"><li class="navHover">HANDLEVOGN</li></a>
                    </ul>
                </nav>
            </header>
            <div id="backgroundHeader" style="background-image: url('bilder/restaurant.jpg');"></div>
            <main>
                <?php
                    if (isset($_GET['handlevogn'])) {
                        if ($_GET['handlevogn'] == "oppdatert") {
                ?>
                            <div class="brukerMelding">
                                <p>Varen ble lagt i handlevognen</p>
                            </div>
                <?php
                        }
                    }
                ?>

                <div class="kategoriInnhold">
                    <?php
                        if (isset($_GET['kategori'])) {

                            $forrett = $hovedrett = $dessert = "";

                            if ($_GET['kategori'] == "forrett") {
                                $kategori_id = '1';
                                $kategori_navn = 'forrett';
                                $forrett = 'aktiv';
                            }
                            if ($_GET['kategori'] == "hovedrett") {
                                $kategori_id = '2';
                                $kategori_navn = 'hovedrett';
                                $hovedrett = 'aktiv';
                            }
                            if ($_GET['kategori'] == "dessert") {
                                $kategori_id = '3';
                                $kategori_navn = 'dessert';
                                $dessert = 'aktiv';
                            } ?>
                            <nav id="kategorier">
                                <ul>
                                    <a class="<?php echo $forrett; ?>" href="meny.php?kategori=forrett"><li>Foretter</li></a>
                                    <a class="<?php echo $hovedrett; ?>" href="meny.php?kategori=hovedrett"><li>Hovedretter</li></a>
                                    <a class="<?php echo $dessert; ?>" href="meny.php?kategori=dessert"><li>Desserter</li></a>
                                    <a href="handlevogn.php" id="handlevognLink">
                                        <li>
                                            <span>Gå til handlevogn</span>
                                            <svg width="20" height="20">
                                                <polygon points="5,0 20,10 5,20" fill="white" />
                                            </svg>
                                        </li>
                                    </a>
                                </ul>
                            </nav>
                    <?php
                            $sql = "SELECT rettid, rettnavn, pris, bildefil FROM rett WHERE kategoriid=$kategori_id";
                            $datasett = $tilkobling->query($sql);

                            while($rad = mysqli_fetch_array($datasett)) { ?>
                                <div class="rett">
                                    <img src="bilder/<?php echo $rad['bildefil']; ?>" height="165px"></img>
                                    <h2 class="rettnavn"><?php echo $rad['rettnavn']; ?></h2>
                                    <h2 class="pris"><?php echo $rad['pris']; ?>,-</h2>
                                    <form action="meny.php" method="post">
                                        <lable>Antall:</lable>
                                        <input type="number" min="1" max="1000" name="antall" value="1">
                                        <input hidden type="number" name="rettid" value="<?php echo $rad['rettid']; ?>">
                                        <input hidden type="text" name="kategori" value="<?php echo $kategori_navn; ?>">
                                        <button name="legg_i_handlevogn" type="submit" value="Submit">Legg i handlevogn</button>
                                    </form>
                                </div>
                    <?php
                            }
                        } else { ?>
                            <nav id="kategorier">
                                <ul>
                                    <a href="meny.php?kategori=forrett"><li>Foretter</li></a>
                                    <a href="meny.php?kategori=hovedrett"><li>Hovedretter</li></a>
                                    <a href="meny.php?kategori=dessert"><li>Desserter</li></a>
                                    <a href="handlevogn.php" id="handlevognLink">
                                        <li>
                                            <span>Gå til handlevogn</span>
                                            <svg width="20" height="20">
                                                <polygon points="5,0 20,10 5,20" fill="white" />
                                            </svg>
                                        </li>
                                    </a>
                                </ul>
                            </nav>
                            <div id="brukerTips" style="margin:auto;padding:50px;text-align:center;font-size:20px;">
                                <p>Velg en kategori over</p>
                            </div>
                    <?php } ?>
                </div>
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

            $(window).scroll(function() {
                if($(window).scrollTop() > 10) {
                    $('.mainHeader').css('background-color', '#333');
                    $('.mainHeader nav a').css('padding', '0');
                    $('.mainHeader img').css('clip', 'rect(0px, 186px, 54px, 0px)');
                    $('.mainHeader img').css('padding', '0 10px');
                    $('#brukerNav ul').slideUp(300);
                } else {
                    $('.mainHeader').css('background-color', 'rgba(0, 0, 0, 0.5)');
                    $('.mainHeader nav a').css('padding', '75px 0 70px 0');
                    $('.mainHeader img').css('clip', 'rect(0px, 186px, 195px, 0px)');
                    $('.mainHeader img').css('padding', '10px');
                    $('#brukerNav ul').slideDown(700);
                }
            });

            function brukerNav_Toggle() {
                $('#brukerNav ul').slideToggle();
            }

            $('#brukerNav_knapp').click(function() {
                brukerNav_Toggle();
            });
        </script>
    </body>
</html>
