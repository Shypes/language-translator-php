<?php

class language {

    var $LanguageData = array();
    var $FolerLanguage = array();

    function __construct($options = array()) {
        $this->reset($options);
    }

    function setOptions ($options){
        $this->option = array_merge($this->default, $options);
    }

    function reset ($options){
        $this->default = [
            "default_lang" => "en",
            "__basedir" => "./",
            "ext" => ".json",
            "langFolder" => 'lang',
        ];
        $this->setOptions($options);
        $this->active_lang = $this->option['default_lang'];
        $this->loaded = false;
        $this->load_from_file = true;
        $this->setPath();
    }

    function setActiveLang($language){
        $language = ($language && $language != '' && gettype($language) == 'string')  ? $language : false;
        if($language) $this->active_lang = trim($language);
    }

    function setExtention($ext){
        $this->option['ext'] = $ext;
    }

    function setLoadFromFile($load){
        $this->load_from_file = !$load ? false : true;
    }

    function setBaseDir($directory){
        $this->option['__basedir'] = $directory;
        $this->setPath();
    }

    function setlanguageDir($directory){
        $this->option['langFolder'] = $directory;
        $this->setPath();
        $this->init(false);
        foreach($this->FolerLanguage[$this->option['langFolder']] as $language => $data){
            $this->load($language, $data);
        }
    }

    function setDefaultLang($language){
        $this->option['default_lang'] = $language;
        $this->loaded = false;
    }

    function setPath(){
        $this->langPath = $this->option['__basedir'] .'/'. $this->option['langFolder'];
        if (!array_key_exists($this->option['langFolder'], $this->FolerLanguage)){
            $this->FolerLanguage[$this->option['langFolder']] = array();
        }
    }

    function getPath(){
        return $this->langPath;
    }

    function text($text, $language = false,  $param=array()){
        $language = ($language && $language != '' &&  gettype($language) == 'string')  ? $language : $this->active_lang;
        if (array_key_exists($language, $this->LanguageData)) {
            if (array_key_exists($text, $this->LanguageData[$language])) {
                if(count($param) == 0)
                    return $this->LanguageData[$language][$text];
                else
                    return $this->renderString($language, $this->LanguageData[$language][$text], $param);
            }
        }
        return $text;
    }

    function gettext($text, $language = false,  $param=array()){
        return $this->text($text, $language,  $param);
    }

    function renderString($language, $template, $variables) {
        return preg_replace_callback('/\${(.+?)}/',
                 function($matches) use ($variables) {
            return   $this->gettext($variables[$matches[1]]);
        }, $template);
    }

    function translate ($text, $language=false, $param=array()){
        $this->init($language);
        return $this->text($text, $language, $param);
    }

    function get($text, $language=false, $param=array()){
        return $this->translate($text, $language, $param);
    }

    function init ($language){
        $this->setActiveLang($language);
        $this->loadDefaultLang();
        $this->loadActiveLang();
    }

    function loadDefaultLang(){
        if($this->loaded == false){
            $this->loadLanguage($this->option['default_lang']);
        }
        $this->loaded = true;
    }

    function loadActiveLang(){
        $this->loadLanguage($this->active_lang);
    }

    function hasLoadedLanguage($language){
        return array_key_exists($language, $this->FolerLanguage[$this->option['langFolder']]);
    }

    function canLoad($language){
        $file_path = $this->getPath();
        return is_file("${file_path}/{$language}{$this->option['ext']}");
    }

    function markAsLoaded($language){
        $this->loadFolderLanguage($language);
    }

    function loadFolderLanguage($language, $data =array()){
        $this->FolerLanguage[$this->option['langFolder']][$language] = $data;
    }

    function getFolderLanguage($language){
        return $this->FolerLanguage[$this->option['langFolder']][$language];
    }

    function loadFile($language){
        try {
            $file_path = $this->getPath();
            return json_decode(file_get_contents("${file_path}/{$language}{$this->option['ext']}"),true);
        } catch (Exception $e) {
            return array();
        }
    }

    function loadLanguage($language){
        if ($this->load_from_file 
        && !$this->hasLoadedLanguage($language)
        ) {
            if($this->canLoad($language)){ 
                $this->loadFolderLanguage($language, $this->loadFile($language));
                $this->load($language, $this->getFolderLanguage($language));
            }else{
                $this->markAsLoaded($language);
            }
        }
    }

    function load($language, $data){
        if (!array_key_exists($language, $this->LanguageData)) {
            $this->LanguageData[$language] = $data;
        }else{
            $this->LanguageData[$language] = array_merge(
                $this->LanguageData[$language], 
                $data
            );
        }
    }
}
?>