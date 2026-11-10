<?php

require_once __DIR__ . '/../classes/crud.php';

class JournalModel extends Crud {

    // Ajoute une visite dans le journal de bord
    public function add($ip, $username, $page){
        return $this->insert('journal', [
            'Ip' => $ip,
            'Date_visite' => date('Y-m-d H:i:s'),
            'Username' => $username,
            'Page' => mb_substr($page, 0, 255)
        ]);
    }

    // Les visites les plus récentes en premier
    public function getAll(){
        $journal = $this->select('journal', 'idJournal', 'DESC');

        return $journal;
    }

    public function countAll(){
        return (int) $this->query("SELECT COUNT(*) FROM journal")->fetchColumn();
    }
}
