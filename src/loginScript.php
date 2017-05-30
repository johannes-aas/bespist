<?php
    session_start();

    $tilkobling = mysqli_connect("localhost","root","","bespist");

    $brukernavn = $_SESSION['brukernavn'];
    $passord = $_SESSION['passord'];

    $sql = "SELECT brukerid, brukernavn, passord FROM bruker WHERE brukernavn='$brukernavn' AND passord='$passord'";
    $datasett = $tilkobling->query($sql);

    if(!$rad = $datasett->fetch_assoc()) {
        header("Location: registrer.php?error");
    } else {
        $_SESSION['brukerid'] = $rad['brukerid'];
        header("Location: min_side.php");
    }
?>
