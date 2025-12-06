<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\WargaModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class PengaduanController extends BaseController
{
    protected $pengaduanModel;
    protected $wargaModel;
    protected $userModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        $this->wargaModel = new WargaModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengaduan Masyarakat - Sistem Pelayanan Kembangan Raya',
            'pengaduan' => $this->pengaduanModel->findAll(),
        ];

        // If admin/petugas, show all, else show user's own complaints
        if (session()->has('user') && in_array(session('user')['role'], ['admin', 'petugas'])) {
            $data['pengaduan'] = $this->pengaduanModel->findAll();
        } elseif (session()->has('warga')) {
            $data['pengaduan'] = $this->pengaduanModel->where('warga_id', session('warga')['id_warga'])->findAll();
        }

        return view('pengaduan/index', $data);
    }

    public function create()
    {
        // Check if user is logged in
        if (!session()->has('warga')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk membuat pengaduan');
        }

        $data = [
            'title' => 'Buat Pengaduan Baru - Sistem Pelayanan Kembangan Raya',
        ];

        return view('pengaduan/create', $data);
    }

    public function store()
    {
        if (!session()->has('warga')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $rules = [
            'judul' => 'required|min_length[5]|max_length[200]',
            'isi_pengaduan' => 'required|min_length[10]',
            'lokasi' => 'permit_empty|max_length[255]',
            'lampiran' => 'permit_empty|uploaded[lampiran]|max_size[lampiran,2048]|ext_in[lampiran,jpg,jpeg,png,pdf]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'warga_id' => session('warga')['id_warga'],
            'judul' => $this->request->getPost('judul'),
            'isi_pengaduan' => $this->request->getPost('isi_pengaduan'),
            'lokasi' => $this->request->getPost('lokasi'),
            'status' => 'baru',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Handle file upload
        $lampiran = $this->request->getFile('lampiran');
        if ($lampiran && $lampiran->isValid() && !$lampiran->hasMoved()) {
            $newName = $lampiran->getRandomName();
            $lampiran->move('uploads/pengaduan', $newName);
            $data['lampiran'] = 'uploads/pengaduan/' . $newName;
        }

        if ($this->pengaduanModel->insert($data)) {
            return redirect()->to('/pengaduan')->with('success', 'Pengaduan berhasil dikirim dan akan segera diproses');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim pengaduan');
        }
    }

    public function show($id)
    {
        $pengaduan = $this->pengaduanModel->find($id);

        if (!$pengaduan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Check permission
        if (!session()->has('user') && (!session()->has('warga') || session('warga')['id_warga'] != $pengaduan['warga_id'])) {
            return redirect()->to('/pengaduan')->with('error', 'Anda tidak memiliki akses ke pengaduan ini');
        }

        $data = [
            'title' => 'Detail Pengaduan - ' . $pengaduan['judul'],
            'pengaduan' => $pengaduan,
            'warga' => $this->wargaModel->find($pengaduan['warga_id']),
            'petugas' => $pengaduan['petugas_id'] ? $this->userModel->find($pengaduan['petugas_id']) : null,
        ];

        return view('pengaduan/show', $data);
    }

    public function edit($id)
    {
        $pengaduan = $this->pengaduanModel->find($id);

        if (!$pengaduan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Only admin/petugas can edit status
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/pengaduan')->with('error', 'Anda tidak memiliki akses untuk mengedit pengaduan');
        }

        // Get warga data
        $warga = $this->wargaModel->find($pengaduan['warga_id']);

        $data = [
            'title' => 'Update Status Pengaduan - ' . $pengaduan['judul'],
            'pengaduan' => $pengaduan,
            'warga' => $warga,
            'petugas' => $this->userModel->where('role', 'petugas')->findAll(),
        ];

        return view('pengaduan/edit', $data);
    }

    public function update($id)
    {
        $pengaduan = $this->pengaduanModel->find($id);

        if (!$pengaduan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Only admin/petugas can update
        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return redirect()->to('/pengaduan')->with('error', 'Anda tidak memiliki akses untuk update pengaduan');
        }

        $rules = [
            'status' => 'required|in_list[baru,diproses,selesai]',
            'catatan' => 'permit_empty|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'status' => $this->request->getPost('status'),
            'petugas_id' => session('user')['id_user'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->request->getPost('catatan')) {
            $data['catatan'] = $this->request->getPost('catatan');
        }

        if ($this->pengaduanModel->update($id, $data)) {
            return redirect()->to('/pengaduan')->with('success', 'Status pengaduan berhasil diupdate');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal update status pengaduan');
        }
    }

    // API endpoint for status updates (AJAX)
    public function updateStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        if (!session()->has('user') || !in_array(session('user')['role'], ['admin', 'petugas'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $pengaduan = $this->pengaduanModel->find($id);
        if (!$pengaduan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pengaduan tidak ditemukan']);
        }

        $data = [
            'status' => $status,
            'petugas_id' => session('user')['id_user'],
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($catatan) {
            $data['catatan'] = $catatan;
        }

        if ($this->pengaduanModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status pengaduan berhasil diupdate',
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal update status']);
        }
    }
}
