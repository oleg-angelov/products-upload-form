<?php

class View {

    public static function printHtml(string $view, array $options = null) {
        
        require('views/' . $view . '.php');
    }

}