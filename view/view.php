<!DOCTYPE html>
<html >
    <head lang="fr">
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <!-- D3.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>

        <!-- SaveImg librairie js locale -->
        <script src="./saveSvg/src/saveSvgAsPng.js"></script>
        <title><?php echo $pagetitle; ?></title>
    </head>
    <body>
    	<nav>
    		<div>
                <a href="index.php?action=readAll&controller=formulaire">Répondre à un formulaire</a>
	    		<a href="index.php?action=readAll&controller=formulaire">Gestion formulaire</a>
                <a href="index.php?action=create&controller=formulaire">Creation de formulaire</a>
                <a href="index.php?action=readAll&controller=visualisation&idFormulaire=1">Affichage visualisation</a>
    		</div>
    	</nav>
		<?php
		// Si $controleur='voiture' et $view='list',
		// alors $filepath="/chemin_du_site/view/voiture/list.php"
		$filepath = File::build_path(array("view", static::$object, "$view.php"));
		require $filepath;
		?>
    </body>
    <p style="border: 1px solid black;text-align:right;padding-right:1em;">
  		Formulaire de VIZUIC
	</p>
</html>