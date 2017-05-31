<?php
    session_start();
?>
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
                        <a><li id="aktiv">KONTAKT</li></a>
                        <a href="handlevogn.php"><li class="navHover">HANDLEVOGN</li></a>
                    </ul>
                </nav>
            </header>
            <div id="backgroundHeader" style="background-image: url('bilder/restaurant.jpg');"></div>
            <main>
                <h2 style="padding-top: 50px;">Ta gjerne kontakt om det er noe du lurer på?</h2>
                <div class="boks">
                    <div style="width:500px;float:left;">
                        <p><strong>E-post:</strong> eksempel@epost</p>
                        <p><strong>Telefon:</strong> + 47 ___ __ ___</p>
                    </div>
                    <div style="width:200px;float:right;">
                        <img  width="200px" src="bilder/svart_logo.png"></img>
                    </div>
                    <br style="clear: both;">
                </div>
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
                } else {
                    $('.mainHeader').css('background-color', 'rgba(0, 0, 0, 0.5)');
                    $('.mainHeader nav a').css('padding', '75px 0 70px 0');
                    $('.mainHeader img').css('clip', 'rect(0px, 186px, 195px, 0px)');
                    $('.mainHeader img').css('padding', '10px');
                }
            });
        </script>
    </body>
</html>
