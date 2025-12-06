<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WargaController extends BaseController
{
    public function index()
    {
        $wargaModel = new \App\Models\WargaModel();
        $data['wargas'] = $wargaModel->findAll();
        return view('wargas/index', $data);
    }
}
