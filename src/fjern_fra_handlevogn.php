<?php
    session_start();

    if (isset($_POST['slett'])) {
        $rett = $_POST['rett'];
        unset($_SESSION['handlevogn'][$rett]);
    }

    header("Location: handlevogn.php");
?>
