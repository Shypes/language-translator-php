<?php

class language {

    var $activeLangData = array();
    var $defaultLangData = array();
    var $passiveLangData = array();

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
    }

    function setDefaultLang($language){
        $this->option['default_lang'] = $language;
        $this->loaded = false;
        $this->defaultLangData = array();
    }

    function setPath(){
        $this->langPath = $this->option['__basedir'] .'/'. $this->option['langFolder'];
    }

    function getPath(){
        return $this->langPath;
    }

    function text($text, $language = false,  $param=array()){
        $language = ($language && $language != '' &&  gettype($language) == 'string')  ? $language : $this->active_lang;
        if (array_key_exists($language, $this->passiveLangData)) {
            if (array_key_exists($text, $this->passiveLangData[$language])) {
                if(count($param) == 0)
                    return $this->passiveLangData[$language][$text];
                else
                    return $this->renderString($language, $this->passiveLangData[$language][$text], $param);
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
        $this->loadPassiveLang();
    }

    function loadDefaultLang(){
        if(count($this->defaultLangData) == 0 
        && $this->loaded == false  
        && $this->load_from_file){
            $file_path = $this->getPath(); 
            $isFile = is_file("${file_path}/{$this->option['default_lang']}{$this->option['ext']}");
            if($isFile){
                try {
                    $this->defaultLangData = json_decode(file_get_contents("${file_path}/{$this->option['default_lang']}{$this->option['ext']}"),true);
                } catch (Exception $e) {
                    $this->defaultLangData = array();
                }
            }
        }
        $this->loaded = true;
    }

    function loadActiveLang(){
        if (!array_key_exists($this->active_lang, $this->activeLangData)
        && $this->load_from_file 
        && !array_key_exists($this->active_lang, $this->passiveLangData)) {
            if ($this->option['default_lang'] == $this->active_lang){
                $this->activeLangData[$this->active_lang] = $this->defaultLangData;
            }else{
                $file_path = $this->getPath();
                $isFile = is_file("${file_path}/{$this->active_lang}{$this->option['ext']}");
                if($isFile){
                    try {
                        $this->activeLangData[$this->active_lang] = json_decode(file_get_contents("${file_path}/{$this->active_lang}{$this->option['ext']}"),true);
                    } catch (Exception $e) {
                        $this->activeLangData[$this->active_lang] = array();
                    }
                }else{
                    $this->activeLangData[$this->active_lang] = array();
                }
            }      
        }
    }

    function loadPassiveLang(){
        if (!array_key_exists($this->active_lang, $this->passiveLangData)) {
            $this->passiveLangData[$this->active_lang] =  $this->defaultLangData;
            if (array_key_exists($this->active_lang, $this->activeLangData)) {
                $this->passiveLangData[$this->active_lang] = array_merge(
                    $this->passiveLangData[$this->active_lang], 
                    $this->activeLangData[$this->active_lang]
                );
            }
        }
    }

    function load($language, $data){
        if (!array_key_exists($language, $this->passiveLangData)) {
            $this->passiveLangData[$language] = $data;
        }else{
            $this->passiveLangData[$language] = array_merge(
                $this->passiveLangData[$language], 
                $data
            );
        }
    }

    function loadlanguage($language, $data){
        return $this->load($language, $data);
    }
}
?>