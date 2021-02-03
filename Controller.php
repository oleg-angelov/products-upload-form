<?php

abstract class Controller {

    protected string $view;
    protected array $options;
    
    protected function setView(string $view) {
        $this->view = $view;
    }

    public function getView() {
        return $this->view;
    }

    public function printHtml() {
        View::printHtml($this->getView(), $this->options);
    }
  
    public function setOption(string $option, string $param)
    {
        $this->options[$option] = $param;
    }
}
