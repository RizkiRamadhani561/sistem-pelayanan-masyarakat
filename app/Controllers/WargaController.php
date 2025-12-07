<?php

/**
 * WargaController - Controller untuk mengelola data warga
 *
 * Controller ini mengatur operasi CRUD untuk data warga masyarakat,
 * termasuk penambahan, pengubahan, penghapusan, dan penampilan data warga.
 *
 * @package App\Controllers
 * @author Sistem Pelayanan Masyarakat Kembangan Raya
 * @version 1.0.0
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\WargaModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class WargaController
 *
 * Mengelola semua operasi terkait data warga dalam sistem
 */
class WargaController extends BaseController
{
    /**
     * Model untuk mengelola data warga
     * @var WargaModel
     */
    protected $wargaModel;

    /**
     * Constructor - Inisialisasi controller
     *
     * Menginisialisasi model warga untuk digunakan dalam controller
     */
    public function __construct()
    {
        $this->wargaModel = new WargaModel();
    }

    /**
     * Menampilkan daftar semua warga
     *
     * @return \CodeIgniter\HTTP\ResponseInterface View daftar warga
     */
    public function index()
    {
        $data = [
            'title' => 'Daftar Warga - Sistem Pelayanan Masyarakat',
            'wargas' => $this->wargaModel->findAll(),
        ];

        return view('wargas/index', $data);
    }

    /**
     * Menampilkan form untuk menambah warga baru
     *
     * @return \CodeIgniter\HTTP\ResponseInterface View form tambah warga
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Warga Baru - Sistem Pelayanan Masyarakat',
        ];

        return view('wargas/create', $data);
    }

    /**
     * Menyimpan data warga baru ke database
     *
     * Fungsi utama untuk menambahkan warga baru ke dalam database
     * dengan validasi lengkap dan penanganan error
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke daftar warga atau kembali ke form
     */
    public function store()
    {
        // Log untuk debugging
        log_message('debug', 'WargaController::store() dipanggil');

        // Aturan validasi untuk data warga
        $validationRules = [
            'nik' => [
                'rules' => 'required|numeric|exact_length[16]|is_unique[warga.nik]',
                'errors' => [
                    'required' => 'NIK wajib diisi.',
                    'numeric' => 'NIK harus berupa angka.',
                    'exact_length' => 'NIK harus terdiri dari 16 digit.',
                    'is_unique' => 'NIK sudah terdaftar dalam sistem.'
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required|min_length[3]|max_length[150]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal 3 karakter.',
                    'max_length' => 'Nama lengkap maksimal 150 karakter.'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required|in_list[L,P]',
                'errors' => [
                    'required' => 'Jenis kelamin wajib dipilih.',
                    'in_list' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).'
                ]
            ],
            'tempat_lahir' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Tempat lahir wajib diisi.',
                    'max_length' => 'Tempat lahir maksimal 100 karakter.'
                ]
            ],
            'tanggal_lahir' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'Tanggal lahir wajib diisi.',
                    'valid_date' => 'Format tanggal lahir tidak valid.'
                ]
            ],
            'alamat' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Alamat lengkap wajib diisi.',
                    'min_length' => 'Alamat minimal 10 karakter.'
                ]
            ],
            'rt_rw' => [
                'rules' => 'required|regex_match[/^\d{1,2}\/\d{1,2}$/]',
                'errors' => [
                    'required' => 'RT/RW wajib diisi.',
                    'regex_match' => 'Format RT/RW tidak valid. Gunakan format: 01/02'
                ]
            ],
            'kecamatan' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Kecamatan wajib diisi.',
                    'max_length' => 'Kecamatan maksimal 100 karakter.'
                ]
            ],
            'kab_kota' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Kabupaten/Kota wajib diisi.',
                    'max_length' => 'Kabupaten/Kota maksimal 100 karakter.'
                ]
            ],
            'provinsi' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Provinsi wajib diisi.',
                    'max_length' => 'Provinsi maksimal 100 karakter.'
                ]
            ],
            'no_hp' => [
                'rules' => 'required|regex_match[/^[0-9+\-\s()]+$/]|min_length[10]',
                'errors' => [
                    'required' => 'Nomor HP wajib diisi.',
                    'regex_match' => 'Format nomor HP tidak valid.',
                    'min_length' => 'Nomor HP minimal 10 karakter.'
                ]
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email|max_length[150]|is_unique[warga.email]',
                'errors' => [
                    'valid_email' => 'Format email tidak valid.',
                    'max_length' => 'Email maksimal 150 karakter.',
                    'is_unique' => 'Email sudah terdaftar dalam sistem.'
                ]
            ],
        ];

        // Jalankan validasi
        if (!$this->validate($validationRules)) {
            log_message('debug', 'Validasi gagal: ' . json_encode($this->validator->getErrors()));

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Data yang Anda masukkan tidak valid. Silakan periksa kembali.');
        }

        // Siapkan data untuk disimpan
        $dataWarga = [
            'nik' => $this->request->getPost('nik'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            'rt_rw' => $this->request->getPost('rt_rw'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kab_kota' => $this->request->getPost('kab_kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'no_hp' => $this->request->getPost('no_hp'),
            'email' => $this->request->getPost('email') ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        log_message('debug', 'Data warga yang akan disimpan: ' . json_encode($dataWarga));

        try {
            // Simpan data ke database menggunakan WargaModel
            $result = $this->wargaModel->insert($dataWarga);

            if ($result) {
                log_message('debug', 'Data warga berhasil disimpan dengan ID: ' . $result);

                return redirect()->to('/wargas')
                    ->with('success', 'Data warga berhasil ditambahkan ke database dengan ID: ' . $result);
            } else {
                log_message('error', 'Gagal menyimpan data warga - insert mengembalikan false');

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan data warga ke database. Silakan coba lagi.');
            }

        } catch (\Exception $e) {
            log_message('error', 'Exception saat menyimpan warga: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail warga berdasarkan ID
     *
     * @param int $id ID warga
     * @return \CodeIgniter\HTTP\ResponseInterface View detail warga
     */
    public function show($id)
    {
        $warga = $this->wargaModel->find($id);

        if (!$warga) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Warga tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Warga - ' . $warga['nama_lengkap'],
            'warga' => $warga,
        ];

        return view('wargas/show', $data);
    }

    /**
     * Menampilkan form edit warga
     *
     * @param int $id ID warga
     * @return \CodeIgniter\HTTP\ResponseInterface View form edit warga
     */
    public function edit($id)
    {
        $warga = $this->wargaModel->find($id);

        if (!$warga) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Warga tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Warga - ' . $warga['nama_lengkap'],
            'warga' => $warga,
        ];

        return view('wargas/edit', $data);
    }

    /**
     * Update data warga
     *
     * @param int $id ID warga
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke daftar warga
     */
    public function update($id)
    {
        $warga = $this->wargaModel->find($id);

        if (!$warga) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Warga tidak ditemukan');
        }

        $validationRules = [
            'nik' => [
                'rules' => 'required|numeric|exact_length[16]|is_unique[warga.nik,id_warga,' . $id . ']',
                'errors' => [
                    'required' => 'NIK wajib diisi.',
                    'numeric' => 'NIK harus berupa angka.',
                    'exact_length' => 'NIK harus terdiri dari 16 digit.',
                    'is_unique' => 'NIK sudah terdaftar dalam sistem.'
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required|min_length[3]|max_length[150]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal 3 karakter.',
                    'max_length' => 'Nama lengkap maksimal 150 karakter.'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required|in_list[L,P]',
                'errors' => [
                    'required' => 'Jenis kelamin wajib dipilih.',
                    'in_list' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).'
                ]
            ],
            'tempat_lahir' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Tempat lahir wajib diisi.',
                    'max_length' => 'Tempat lahir maksimal 100 karakter.'
                ]
            ],
            'tanggal_lahir' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'Tanggal lahir wajib diisi.',
                    'valid_date' => 'Format tanggal lahir tidak valid.'
                ]
            ],
            'alamat' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Alamat lengkap wajib diisi.',
                    'min_length' => 'Alamat minimal 10 karakter.'
                ]
            ],
            'rt_rw' => [
                'rules' => 'required|regex_match[/^\d{1,2}\/\d{1,2}$/]',
                'errors' => [
                    'required' => 'RT/RW wajib diisi.',
                    'regex_match' => 'Format RT/RW tidak valid. Gunakan format: 01/02'
                ]
            ],
            'kecamatan' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Kecamatan wajib diisi.',
                    'max_length' => 'Kecamatan maksimal 100 karakter.'
                ]
            ],
            'kab_kota' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Kabupaten/Kota wajib diisi.',
                    'max_length' => 'Kabupaten/Kota maksimal 100 karakter.'
                ]
            ],
            'provinsi' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Provinsi wajib diisi.',
                    'max_length' => 'Provinsi maksimal 100 karakter.'
                ]
            ],
            'no_hp' => [
                'rules' => 'required|regex_match[/^[0-9+\-\s()]+$/]|min_length[10]',
                'errors' => [
                    'required' => 'Nomor HP wajib diisi.',
                    'regex_match' => 'Format nomor HP tidak valid.',
                    'min_length' => 'Nomor HP minimal 10 karakter.'
                ]
            ],
            'email' => [
                'rules' => 'permit_empty|valid_email|max_length[150]|is_unique[warga.email,id_warga,' . $id . ']',
                'errors' => [
                    'valid_email' => 'Format email tidak valid.',
                    'max_length' => 'Email maksimal 150 karakter.',
                    'is_unique' => 'Email sudah terdaftar dalam sistem.'
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Data yang Anda masukkan tidak valid. Silakan periksa kembali.');
        }

        $dataWarga = [
            'nik' => $this->request->getPost('nik'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'alamat' => $this->request->getPost('alamat'),
            'rt_rw' => $this->request->getPost('rt_rw'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kab_kota' => $this->request->getPost('kab_kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'no_hp' => $this->request->getPost('no_hp'),
            'email' => $this->request->getPost('email') ?: null,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->wargaModel->update($id, $dataWarga)) {
            return redirect()->to('/wargas')
                ->with('success', 'Data warga berhasil diperbarui.');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data warga.');
        }
    }

    /**
     * Hapus data warga
     *
     * @param int $id ID warga
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect ke daftar warga
     */
    public function delete($id)
    {
        $warga = $this->wargaModel->find($id);

        if (!$warga) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Warga tidak ditemukan');
        }

        if ($this->wargaModel->delete($id)) {
            return redirect()->to('/wargas')
                ->with('success', 'Data warga berhasil dihapus.');
        } else {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data warga.');
        }
    }

    /**
     * Fungsi utilitas untuk menambahkan warga baru (khusus untuk API/testing)
     *
     * @param array $dataWarga Data warga yang akan ditambahkan
     * @return int|false ID warga yang baru ditambahkan atau false jika gagal
     */
    public function tambahWarga(array $dataWarga)
    {
        try {
            // Validasi data warga sebelum menyimpan
            if (!$this->validasiDataWarga($dataWarga)) {
                log_message('error', 'Validasi data warga gagal');
                return false;
            }

            // Tambahkan timestamp jika belum ada
            if (!isset($dataWarga['created_at'])) {
                $dataWarga['created_at'] = date('Y-m-d H:i:s');
                $dataWarga['updated_at'] = date('Y-m-d H:i:s');
            }

            // Simpan ke database
            $result = $this->wargaModel->insert($dataWarga);

            if ($result) {
                log_message('info', 'Warga baru berhasil ditambahkan dengan ID: ' . $result);
                return $result;
            } else {
                log_message('error', 'Gagal menambahkan warga ke database');
                return false;
            }

        } catch (\Exception $e) {
            log_message('error', 'Exception dalam tambahWarga: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Validasi data warga sebelum disimpan
     *
     * @param array $data Data warga yang akan divalidasi
     * @return bool True jika valid, false jika tidak
     */
    private function validasiDataWarga(array $data)
    {
        // Cek field wajib
        $requiredFields = ['nik', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'rt_rw', 'kecamatan', 'kab_kota', 'provinsi', 'no_hp'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                log_message('error', 'Field wajib kosong: ' . $field);
                return false;
            }
        }

        // Validasi NIK (16 digit)
        if (!preg_match('/^\d{16}$/', $data['nik'])) {
            log_message('error', 'NIK tidak valid: ' . $data['nik']);
            return false;
        }

        // Validasi jenis kelamin
        if (!in_array($data['jenis_kelamin'], ['L', 'P'])) {
            log_message('error', 'Jenis kelamin tidak valid: ' . $data['jenis_kelamin']);
            return false;
        }

        // Validasi format RT/RW
        if (!preg_match('/^\d{1,2}\/\d{1,2}$/', $data['rt_rw'])) {
            log_message('error', 'Format RT/RW tidak valid: ' . $data['rt_rw']);
            return false;
        }

        return true;
    }
}
