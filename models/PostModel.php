<?php

require_once __DIR__ . '/../classes/crud.php';
require_once __DIR__ . '/PostCategorieModel.php';

class PostModel extends Crud {

    public function getAll(){
        $sql = "SELECT
                    p.*,
                    u.Nom AS Auteur,
                    GROUP_CONCAT(
                        c.Nom
                        ORDER BY c.Nom
                        SEPARATOR ', '
                    ) AS Categories
                FROM posts p
                INNER JOIN users u
                    ON p.Users_idUsers = u.idUsers
                LEFT JOIN post_categorie pc
                    ON p.idPosts = pc.Posts_idPosts1
                LEFT JOIN categories c
                    ON pc.Categories_idCategories = c.idCategories
                GROUP BY p.idPosts
                ORDER BY p.Create_at DESC";

        $posts = $this->query($sql)->fetchAll();

        return $posts;
    }

    public function getById($id){
        $sql = "SELECT
                    p.*,
                    u.Nom AS Auteur,
                    GROUP_CONCAT(
                        c.Nom
                        ORDER BY c.Nom
                        SEPARATOR ', '
                    ) AS Categories
                FROM posts p
                INNER JOIN users u
                    ON p.Users_idUsers = u.idUsers
                LEFT JOIN post_categorie pc
                    ON p.idPosts = pc.Posts_idPosts1
                LEFT JOIN categories c
                    ON pc.Categories_idCategories = c.idCategories
                WHERE p.idPosts = :id
                GROUP BY p.idPosts";

        $stmt = $this->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function countAll(){
        return (int) $this->query("SELECT COUNT(*) FROM posts")->fetchColumn();
    }

    public function getCategoryIds($id){
        $postCategorieModel = new PostCategorieModel($this);

        return $postCategorieModel->getIdsByPost($id);
    }

    public function createPost($data, $categoryIds){
        $this->beginTransaction();

        try {
            $idPost = $this->insert('posts', $data);

            if ($idPost === false) {
                throw new RuntimeException('Échec de l’ajout.');
            }

            $postCategorieModel = new PostCategorieModel($this);

            $postCategorieModel->addForPost(
                $idPost,
                $categoryIds
            );

            $this->commit();

            return $idPost;
        } catch (Throwable $e) {
            $this->rollBack();

            throw $e;
        }
    }

    public function updatePost($id, $data, $categoryIds){
        $this->beginTransaction();

        try {
            $data['idPosts'] = $id;

            $updated = $this->update(
                'posts',
                $data,
                'idPosts'
            );

            if (!$updated) {
                throw new RuntimeException(
                    'Échec de la modification.'
                );
            }

            $postCategorieModel = new PostCategorieModel($this);

            $postCategorieModel->replaceForPost(
                $id,
                $categoryIds
            );

            $this->commit();
        } catch (Throwable $e) {
            $this->rollBack();

            throw $e;
        }
    }

    public function deletePost($id){
        $this->beginTransaction();

        try {
            $postCategorieModel = new PostCategorieModel($this);

            $postCategorieModel->deleteForPost($id);

            $deleted = $this->delete(
                'posts',
                $id,
                'idPosts'
            );

            if (!$deleted) {
                throw new RuntimeException(
                    'Échec de la suppression.'
                );
            }

            $this->commit();
        } catch (Throwable $e) {
            $this->rollBack();

            throw $e;
        }
    }
}