<?php
    foreach ($tab_q as $q) {
    	echo "<a href='index.php?action=readAll&controller=champ'>" . $q->get('nomFormulaire') . "</a>";
    }
?>