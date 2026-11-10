<?php

require_once __DIR__ . '/../classes/crud.php';

class CategorieModel extends Crud {

    public function getAll(){
        $categories = $this->select('categories', 'Nom');

        return $categories;
    }
}