<?php

require_once("../language.php");

use Shypes\language;

$Language = new language([
   "default_lang" => "en",
   "__basedir" =>  getcwd()
]);

$translated = $Language->get('something_went_wrong');

var_dump($translated);

?>