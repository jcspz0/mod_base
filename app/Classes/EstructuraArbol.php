<?php

namespace base\Classes;

//use \base\Model\Parametro;

class EstructuraArbol {

    public $id;
    public $parent;
    public $text;
    public $icon = "glyphicon glyphicon-align-justify";
    public $state = array("opened" => true, "selected" => false);

}