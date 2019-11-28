<?php
    foreach ($tab_q as $q) {
    	echo "<a href='index.php?action=readAll&controller=champ&idFormulaire=" . $q->get('idFormulaire') . "'>" . $q->get('nomFormulaire') . "</a>";
    }
?>