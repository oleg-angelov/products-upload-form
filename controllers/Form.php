<?php

class Form extends Controller {

    function __construct() {

        $dbManager = new DbManager;
        $imports = $dbManager->getAllObjects('Log');
        $htmlImportLines = '';

        foreach ($imports as $import) {
            $htmlImportLines .= 'Import on ' . $import->date . ', file : ' . $import->file_name . '<br />';
        }

        $this->setView('form');
        $this->setOption('title', 'File upload');
        $this->setOption('imports', $htmlImportLines);

    }
}