<?php

require_once("../language.php");

use Shypes\language;

$LangParser = new language();

$LangParser->setBaseDir(getcwd());

$translate = $LangParser->init('ar');

var_dump($LangParser->gettext('missing_truck', 'ar', ['status'=>"delivered"]));

var_dump($LangParser->gettext('something_went_wrong'));

var_dump($LangParser->gettext('missing_required_validation'));

var_dump($LangParser->gettext('email_phone_validation'));

?>