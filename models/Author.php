<?php

namespace app\models;

interface Author{
    public function getName();
    public function create();
    public function update($POST);
}
?>