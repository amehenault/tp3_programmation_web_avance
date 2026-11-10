<?php

require_once __DIR__ . '/../classes/crud.php';

class PostCategorieModel {

    private $db;

    public function __construct(Crud $db){
        $this->db = $db;
    }

    public function getIdsByPost($id){
        $sql = "SELECT Categories_idCategories
                FROM post_categorie
                WHERE Posts_idPosts1 = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return array_map(
            'intval',
            array_column(
                $stmt->fetchAll(),
                'Categories_idCategories'
            )
        );
    }

    public function addForPost($id, $categoryIds){
        foreach ($categoryIds as $idCategorie) {
            $inserted = $this->db->insert('post_categorie', [
                'Categories_idCategories' => $idCategorie,
                'Posts_idPosts1' => $id
            ]);

            if ($inserted === false) {
                throw new RuntimeException(
                    'Impossible d’associer une catégorie.'
                );
            }
        }
    }

    public function deleteForPost($id){
        $deleted = $this->db->delete(
            'post_categorie',
            $id,
            'Posts_idPosts1'
        );

        if (!$deleted) {
            throw new RuntimeException(
                'Impossible de retirer les associations.'
            );
        }
    }

    public function replaceForPost($id, $categoryIds){
        $this->deleteForPost($id);

        $this->addForPost($id, $categoryIds);
    }
}