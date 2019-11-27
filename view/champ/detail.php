<?php
    require_once './lib/File.php';
    if($q == false) {

        require File::build_path(array("view", "formulaire", "error.php"));
    }
    else {
        echo "<p>la formulaire : " . htmlspecialchars($q->get('label')) . " d'id : " . htmlspecialchars($q->get('id')) . " et de type : " . htmlspecialchars($q->get('typeInput')) . " <a href=index.php?controller=formulaire&action=delete&id=" . rawurlencode($q->get('id')) . ">" . "Delete" . "</a>  <a href=index.php?controller=formulaire&action=update&id=" . rawurlencode($q->get('id')) . ">" . "Update" . "</a> </p>";
    }
?>
