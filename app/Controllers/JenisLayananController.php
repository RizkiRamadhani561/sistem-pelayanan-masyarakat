<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class JenisLayananController extends BaseController
{
    public function index()
    {
        $jenisLayananModel = new \App\Models\JenisLayananModel();
        $data['jenis_layanan'] = $jenisLayananModel->findAll();
        return view('jenis_layanan/index', $data);
    }
}
