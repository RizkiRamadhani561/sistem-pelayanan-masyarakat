<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PermohonanController extends BaseController
{
    public function index()
    {
        $permohonanModel = new \App\Models\PermohonanModel();
        $data['permohonan'] = $permohonanModel->findAll();
        return view('permohonan/index', $data);
    }
}
