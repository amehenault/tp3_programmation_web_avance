<?php

require_once __DIR__ . '/../models/JournalModel.php';

use App\Providers\View;
use App\Providers\Auth;

class JournalController {

    // Journal de bord (admin seulement)
    public function index(){
        Auth::admin();

        $journalModel = new JournalModel();
        $journal = $journalModel->getAll();

        View::render('journal-index', [
            'pageTitle' => 'Journal de bord',
            'journal' => $journal
        ]);
    }
}
