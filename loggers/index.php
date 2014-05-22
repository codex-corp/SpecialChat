<?

//skip the mysql file if somebody call it from the browser.
if (eregi("index.php", $_SERVER['SCRIPT_NAME'])) {
    Header("Location: ../index.php"); die();
}

?>