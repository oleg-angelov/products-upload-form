<?php

abstract class Base {

    public function getTableName() {
        return strtolower(get_class($this));
    }
}