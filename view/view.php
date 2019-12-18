<!DOCTYPE html>
<html >
    <head lang="fr">
        <meta charset="UTF-8">

        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

        <!-- D3.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>

        <!-- SaveImg librairie js locale -->
        <script src="./saveSvg/src/saveSvgAsPng.js"></script>

        <title><?php echo $pagetitle; ?></title>
    </head>
    <body>
        <header></header>
        <nav class='blue lighten-1'>
        <?php
        if (isset($_SESSION["Identifiant"])) {
    	   echo "
           <div class ='nav-wrapper'>
    		<ul> 
                <li>
                <a href='index.php?action=readAll&controller=formulaire&gestion=0'>Répondre à un formulaire</a></li>
	    		<li><a href='index.php?action=readAll&controller=formulaire&gestion=1'>Gestion formulaire</a></li>
                <li><a href='index.php?action=create&controller=formulaire'>Creation de formulaire</a></li>
                <li><a href='index.php?action=connect&controller=utilisateur'>Profil</a></li>                
                <li><a href='index.php?action=readAll&controller=visualisation&idFormulaire=1'>Affichage visualisation</a>
                </li>
            </ul>
            </div>
    	   ";
        }
        echo "</nav>
        <main>";

		// Si $controleur='voiture' et $view='list',
		// alors $filepath="/chemin_du_site/view/voiture/list.php"
		$filepath = File::build_path(array("view", static::$object, "$view.php"));
		require $filepath;
		?>

    </main>

     <footer class="page-footer blue lighten-1">
        <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">VIZUIC</h5>
                <p class="grey-text text-lighten-4">Vizualisation de l'intelligence collective.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Lien</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Définition VIZUIC</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2014 Copyright Text
            </div>
          </div>
    </footer>

    </body>

   

</html>