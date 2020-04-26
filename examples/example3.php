<?php

require_once("../language.php");

$LangParser = new language();

$LangParser->setBaseDir(getcwd());

function testTranslate ($language, $message) {

   global $LangParser;

   $LangParser->init($language);

   $translated = $LangParser->text($message);

   $data = [
      "message" => $translated,
      "language" => $language
  ];

  var_dump($data);
};

testTranslate('ar' , 'success');

testTranslate('ar' , 'something_went_wrong');

testTranslate('ar' , 'missing_required_validation');

testTranslate('ar' , 'email_phone_validation');




$LangParser->setActiveLang('en');

$messages = ['something_went_wrong', 'missing_required_validation', 'missing_required_validation'];

$last_item = array_pop($messages);

if (count($messages) > 0){

    $messageString = array();

    foreach ($messages as $value) {
        $message = $LangParser->translate($value);
        array_push($messageString, $message);
    }

   var_dump(join(", ", $messageString). " ". $LangParser->translate("and") . " ". $LangParser->translate($last_item));
}else{
   var_dump($LangParser->translate($last_item));
}


$last_item = array_pop($messages);
if (count($messages) > 0){
    $messageString = array();
    foreach ($messages as $value) {
        $message = $LangParser->translate($value);
        array_push($messageString, $message);
    }
    return join($LangParser->translate("COMMA")." ", $messageString). " ". $LangParser->translate("and") . " ". $LangParser->translate($last_item);
}else{
    return $LangParser->translate($last_item);
}

?>
