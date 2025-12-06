<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisLayananModel;
use App\Models\PermohonanModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller untuk mengelola jenis layanan administrasi
 * Mengatur tampilan dan fungsi layanan yang tersedia untuk masyarakat
 */
class JenisLayananController extends BaseController
{
    protected $jenisLayananModel;
    protected $permohonanModel;

    public function __construct()
    {
        $this->jenisLayananModel = new JenisLayananModel();
        $this->permohonanModel = new PermohonanModel();
    }

    /**
     * Menampilkan halaman utama layanan dengan daftar semua jenis layanan
     */
    public function index()
    {
        $data = [
            'title' => 'Layanan Administrasi - Sistem Pelayanan Masyarakat Kembangan Raya',
            'jenis_layanan' => $this->jenisLayananModel->where('aktif', 1)->findAll(),
        ];

        return view('jenis_layanan/index', $data);
    }

    /**
     * Menampilkan detail lengkap dari sebuah layanan tertentu
     */
    public function show($id)
    {
        $layanan = $this->jenisLayananModel->find($id);

        if (!$layanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Cek apakah user sudah login untuk mengetahui status permohonan
        $sudahMengajukan = false;
        if (session()->has('warga')) {
            $sudahMengajukan = $this->permohonanModel
                ->where('warga_id', session('warga')['id_warga'])
                ->where('jenis_id', $id)
                ->whereIn('status', ['diajukan', 'diproses'])
                ->first() ? true : false;
        }

        $data = [
            'title' => $layanan['nama_pelayanan'] . ' - Layanan Administrasi',
            'layanan' => $layanan,
            'sudah_mengajukan' => $sudahMengajukan,
        ];

        return view('jenis_layanan/show', $data);
    }

    /**
     * Membuat permohonan untuk layanan tertentu
     */
    public function ajukan($id)
    {
        if (!session()->has('warga')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk mengajukan permohonan');
        }

        $layanan = $this->jenisLayananModel->find($id);

        if (!$layanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Cek apakah sudah pernah mengajukan
        $existing = $this->permohonanModel
            ->where('warga_id', session('warga')['id_warga'])
            ->where('jenis_id', $id)
            ->whereIn('status', ['diajukan', 'diproses'])
            ->first();

        if ($existing) {
            return redirect()->to('/layanan/' . $id)->with('error', 'Anda sudah memiliki permohonan yang sedang diproses untuk layanan ini');
        }

        $data = [
            'title' => 'Ajukan Permohonan - ' . $layanan['nama_pelayanan'],
            'layanan' => $layanan,
        ];

        return view('jenis_layanan/ajukan', $data);
    }

    /**
     * Menyimpan permohonan layanan yang diajukan
     */
    public function storePermohonan($id)
    {
        if (!session()->has('warga')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $layanan = $this->jenisLayananModel->find($id);

        if (!$layanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'keterangan' => 'permit_empty|max_length[500]',
            'lampiran.*' => 'permit_empty|uploaded[lampiran]|max_size[lampiran,2048]|ext_in[lampiran,jpg,jpeg,png,pdf]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generate nomor permohonan
        $tahun = date('Y');
        $bulan = date('m');
        $count = $this->permohonanModel->where('YEAR(created_at)', $tahun)->countAllResults() + 1;
        $nomorPermohonan = sprintf('%s/%s/%04d', $layanan['kode'], str_pad($count, 4, '0', STR_PAD_LEFT), $tahun);

        $data = [
            'warga_id' => session('warga')['id_warga'],
            'jenis_id' => $id,
            'nomor_permohonan' => $nomorPermohonan,
            'status' => 'diajukan',
            'tanggal_pengajuan' => date('Y-m-d H:i:s'),
            'keterangan' => $this->request->getPost('keterangan'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Handle multiple file uploads
        $lampiranFiles = $this->request->getFiles();
        if (isset($lampiranFiles['lampiran'])) {
            $uploadedFiles = [];
            foreach ($lampiranFiles['lampiran'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/permohonan', $newName);
                    $uploadedFiles[] = 'uploads/permohonan/' . $newName;
                }
            }
            $data['lampiran'] = json_encode($uploadedFiles);
        }

        if ($this->permohonanModel->insert($data)) {
            return redirect()->to('/permohonan')->with('success', 'Permohonan berhasil diajukan dengan nomor: ' . $nomorPermohonan);
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan permohonan');
        }
    }
}
