<?php

require_once("../language.php");

$LangParser = new language();

$LangParser->setBaseDir("./");

$LangParser->setActiveLang('en');

$translated = $LangParser->get('deliver_code', 'en', ['name'=>"John", 'code'=> 343923] );

var_dump($translated);

$translated = $LangParser->translate('something_went_wrong');

var_dump($translated);

$translated = $LangParser->translate('missing_required_validation');

var_dump($translated);

$translated = $LangParser->translate('email_phone_validation');

var_dump($translated);

?>