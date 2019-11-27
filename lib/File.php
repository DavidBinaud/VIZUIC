<?php

class File {

	public static function build_path($path_array) {
		
		$DS = DIRECTORY_SEPARATOR;
		$ROOT_FOLDER = __DIR__ . $DS . "..";

	    // $ROOT_FOLDER (sans slash à la fin) vaut
	    // "/home/ann2/votre_login/public_html/TD5" à l'IUT 
	    return $ROOT_FOLDER. $DS . join($DS, $path_array);
}
}

?>