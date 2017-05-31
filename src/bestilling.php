<?php
    session_start();

    $tilkobling = mysqli_connect("localhost","root","","bespist");

    $brukerid = $_SESSION['brukerid'];

    $sql = "INSERT INTO ordre (ordretidspunkt, brukerid) VALUES (NOW(), '$brukerid')";
    $datasett = $tilkobling->query($sql);

    foreach ($_SESSION['handlevogn'] as $rettid => $antall) {

        $sql = "INSERT INTO ordrelinje (ordrenummer, rettid, antall)
                VALUES ($tilkobling->insert_id, '$rettid', '$antall')";
        $datasett = $tilkobling->query($sql);
    }

    unset($_SESSION['handlevogn']);

    header("Location: handlevogn.php?bestilling=fullført");
?>
