<?php

require_once __DIR__ . '/../classes/crud.php';

class UserModel extends Crud {

    public function getAll(){
        $users = $this->select('users', 'Nom');

        return $users;
    }

    public function getById($id){
        return $this->selectId('users', $id, 'idUsers');
    }

    // Utilisé pour la connexion
    public function getByUsername($username){
        return $this->selectId('users', $username, 'Username');
    }

    public function getByEmail($email){
        return $this->selectId('users', $email, 'Email');
    }

    // Seuls les administrateurs peuvent être auteurs d'un article
    public function getAdmins(){
        $sql = "SELECT * FROM users
                WHERE Role = 'admin'
                ORDER BY Nom";

        return $this->query($sql)->fetchAll();
    }

    public function createUser($data){
        // Le mot de passe est haché avant d'être enregistré (jamais en clair)
        $data['Password'] = password_hash(
            $data['Password'],
            PASSWORD_DEFAULT
        );

        return $this->insert('users', $data);
    }

    // Vérifie le nom d'utilisateur et le mot de passe
    // Retourne l'utilisateur, ou false si les informations sont invalides
    public function checkLogin($username, $password){
        $user = $this->getByUsername($username);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['Password'])) {
            return false;
        }

        return $user;
    }

    public function countAll(){
        return (int) $this->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
