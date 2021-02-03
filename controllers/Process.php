<?php

class Process extends Controller {

    function __construct() {

        $this->setView('result');
        $this->setOption('title', 'File was processed');

        $this->processFile();
    }

    private function processFile() {

        if (isset($_POST['submit']) && isset($_FILES['products_form'])) {

            $file = file_get_contents($_FILES['products_form']['tmp_name']);
            $fileName = $_FILES['products_form']['name'];
            $format = pathinfo($fileName, PATHINFO_EXTENSION);

            $object = DataProcessor::getProcessedData($file, $format);

            $dbManager = new DbManager;

            if ($format === 'xml') {

                foreach ($object as $element) {

                    $product = new Product;
                    $image = new Image;

                    $product->id = (int) $element->id;
                    $product->title = (string) $element->title;
                    $product->vendor = (string) $element->vendor;
                    $product->tags = (string) $element->tags;
                    $product->handle = (string) $element->handle;
                    $product->body_html = (string) $element->{'body-html'};
                    $product->product_type = (string) $element->{'product-type'};
                    $product->created_at = (string) date('Y-m-d H:i:s', strtotime($element->{'created-at'}));
                    $product->published_scope = (string) $element->{'published-scope'};

                    $image->id = (int) $element->image->id;
                    $image->width = (int) $element->image->width;
                    $image->height = (int) $element->image->height;
                    $image->src = (string) $element->image->src;
                    $image->product_id = (int) $element->image->{'product-id'};
                    $image->created_at = (string) date('Y-m-d H:i:s', strtotime($element->image->{'created-at'}));
                    $image->updated_at = (string) date('Y-m-d H:i:s', strtotime($element->image->{'updated-at'}));

                    $dbManager->writeObject($product);
                    $dbManager->writeObject($image);
                }
            } else if ($format === 'csv') {

                foreach ($object as $element) {

                    $inventory = new Inventory;

                    $inventory->amount = (int) $element->amount;
                    $inventory->handle = (string) $element->handle;
                    $inventory->location = (string) $element->location;

                    $recordExists = $dbManager->ifObjectExitst($inventory, ['handle', 'location']);

                    if ($recordExists) {
                        $dbManager->updateObject($inventory, ['handle', 'location']);
                    } else {
                        $dbManager->writeObject($inventory);
                    }
                }
            }

            $log = new Log;

            $log->date = date('Y-m-d H:i:s');
            $log->file_name = $fileName;

            $dbManager->writeObject($log);
        }
    }
}
