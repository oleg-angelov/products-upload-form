<?php

class DataProcessor {

    public static function getProcessedData($file, $extension) {

        $object = null;

        if ($extension === "xml") {

            $object = simplexml_load_string($file);
            
        } else if ($extension === "csv") {

            $lines = explode(PHP_EOL, $file);
            $data = array();
            foreach ($lines as $line) {
                $data[] = str_getcsv($line, ';');
            }

            $keys = $data[0];
            unset($data[0]);

            foreach($data as $line) {
                $i = 0;

                $entry = array();
                foreach($line as $value) {
                    $entry[$keys[$i]] = $value;
                    $i++;
                }
                $object[] = (object) $entry;
            }
        }

        return $object;
    }
}
