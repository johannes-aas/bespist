<?php
    session_start();
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
                        <li></li>
                        <a><li id="aktiv">HJEM</li></a>
                        <a href="meny.php"><li class="navHover">MENY</li></a>
                        <a href="kontakt.php"><li class="navHover">KONTAKT</li></a>
                        <a href="handlevogn.php"><li class="navHover">HANDLEVOGN</li></a>
                    </ul>
                </nav>
            </header>
            <img id="frontLogo" src="bilder/hvit_logo.png"></img>
            <div id="slideShow">
                <div id="slide1" class="slide" style="background-image: url('bilder/restaurant.jpg');"></div>
                <div id="slide2" class="slide" style="background-image: url('bilder/kyllingbryst.jpg');"></div>
                <div id="slide2" class="slide" style="background-image: url('bilder/kokk.jpg');"></div>
                <a class="slideLink" href="meny.php">
                    <div>Se menyen vår</div>
                </a>
            </div>
            <main id="hjem">
                <h1>BESPIST</h1>
                <div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                        culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                    <img src="bilder/per.jpg"></img>
                </div>
            </main>
            <footer>
                <p>&copy; <?php echo date('Y'); ?> Johannes Hansen Aas</p>
            </footer>
        </div>
        <script>
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

            $(document).ready(function() {

                var slideIndex = 0;
                var slides = $('.slide');
                var slideAmt = slides.length;

                function slideShow() {
                    var slide = $('.slide').eq(slideIndex);

                    slides.css('display', 'none');
                    slide.css('display', 'block');
                }

                var interval;
                var autoSlide = function() {
                    interval = setInterval(function() {
                        slideIndex += 1;
                        if (slideIndex > slideAmt - 1) {
                            slideIndex = 0;
                        }
                        slideShow();
                    }, 3000);
                };

                autoSlide();
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
