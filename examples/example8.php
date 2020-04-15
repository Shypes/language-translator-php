<?php

require_once("../language.php");

$Language = new language([
   "default_lang" => "en",
   "__basedir" =>  getcwd()
]);

$translated = $Language->get('something_went_wrong');

var_dump($translated);

?>