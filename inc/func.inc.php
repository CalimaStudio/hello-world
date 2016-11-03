<?php
if (isset ($_GET['lang'])){
  $lang=$_GET['lang'];
  setcookie("lang", $lang);
}
else if (!empty ($_COOKIE['lang'])){
  $lang=$_COOKIE['lang'];
}
else {
  $lang=detect_language();
}

function __($text){
  global $lang;
	 switch ($lang){
	   case 'en':
         return translate($text, 'en');
	   break;
	   case 'de':
	     return translate($text, 'de');
	   break;
	   case 'es':
	   default:
		return $text;
	  }
}

function translate($text, $lang){
  $f=fopen ("inc/lang/".$lang.".php", "r");

  while (!feof($f)){
    $string=fgets($f, 1024);

	if (@preg_match("/^".$text."/i", $string)){
	   $array=explode(":::", $string);
       $array[1]=str_replace("\r\n", "", $array[1]);
       $array[1]=str_replace("\r", "", $array[1]);
       $array[1]=str_replace("\n", "", $array[1]);
	   return $array[1];
	}
  }
  fclose($f);
}

/**
 * Extrae la cadena entre las etiquetas especificadas.
 */
function ExtractString($str, $start, $end)
{
  $str_low = $str;
  $pos_start = strpos($str_low, $start);
  $pos_end = strpos($str_low, $end, ($pos_start + strlen($start)));
  if ( ($pos_start !== false) && ($pos_end !== false) )
   {
	$pos1 = $pos_start + strlen($start);
	$pos2 = $pos_end - $pos1;
	return substr($str, $pos1, $pos2);
   }
}



function detect_language() {
	$conf['lang_default'] = 'es'; // idioma por defecto
	$conf['lang_enabled'] = array('es', 'en', 'fr');
    $languages = preg_replace('/(;q=\d+.\d+)/i', '', getenv('HTTP_ACCEPT_LANGUAGE'));
    $bol_language_detected = false;

//    $language=split (',', $languages);
	$language=preg_split("/,/","$languages");

    // Comprobamos si el navegador usa alguno de los idiomas que hemos
	// predefinido.
    foreach ($language as $tmp_arr_language) {
        foreach ($conf['lang_enabled'] as $lang) {
        //  echo $tmp_arr_language." VS "; echo "$lang"; echo "<br>";
            if (strstr($tmp_arr_language, $lang)) {
                $_SESSION['user_language']=$lang;
                //  echo "Idioma detectado ".$lang;
                return $lang;
            }
        }
    }
   /* Si el navegador usa uno de los idiomas seleccionados, se devuelve el path
      del fichero de idioma
      En caso contrario, se devuelve el path del idioma por defecto */
    return $conf['lang_default'];
}
?>
