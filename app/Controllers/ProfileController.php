<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\WargaModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller untuk mengelola pengaturan profil pengguna
 *
 * Fitur ini memungkinkan:
 * - Warga mengelola profil pribadi
 * - Admin/Petugas mengelola profil admin
 * - Update informasi personal
 * - Upload foto profil
 * - Ubah kata sandi
 */
class ProfileController extends BaseController
{
    protected $userModel;
    protected $wargaModel;

    /**
     * Konstruktor untuk inisialisasi model
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->wargaModel = new WargaModel();
    }

    /**
     * Halaman profil pengguna
     * Menampilkan informasi profil dan form edit
     *
     * Method: GET
     * Route: /profile
     * Akses: Warga yang sudah login
     */
    public function index()
    {
        // Cek apakah user sudah login sebagai warga
        if (!session()->has('warga')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $wargaId = session('warga')['id_warga'];

        // Ambil data warga
        $warga = $this->wargaModel->find($wargaId);

        if (!$warga) {
            return redirect()->to('/dashboard')->with('error', 'Data warga tidak ditemukan');
        }

        $data = [
            'title' => 'Pengaturan Profil - Sistem Pelayanan Masyarakat',
            'warga' => $warga,
            'activeTab' => $this->request->getGet('tab') ?? 'profile'
        ];

        return view('profile/index', $data);
    }

    /**
     * Update informasi profil warga
     * Mengupdate data personal warga
     *
     * Method: POST
     * Route: /profile/update
     * Akses: Warga yang sudah login
     */
    public function update()
    {
        // Cek apakah user sudah login sebagai warga
        if (!session()->has('warga')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
        }

        $wargaId = session('warga')['id_warga'];

        // Validation rules
        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'no_telepon' => 'required|min_length[10]|max_length[15]|regex_match[/^[0-9+\-\s()]+$/]',
            'alamat' => 'required|min_length[10]|max_length[255]',
            'tanggal_lahir' => 'permit_empty|valid_date[Y-m-d]',
            'jenis_kelamin' => 'permit_empty|in_list[L,P]',
            'pekerjaan' => 'permit_empty|max_length[100]',
            'kewarganegaraan' => 'permit_empty|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Cek apakah email sudah digunakan user lain
        $existingWarga = $this->wargaModel
            ->where('email', $this->request->getPost('email'))
            ->where('id_warga !=', $wargaId)
            ->first();

        if ($existingWarga) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email sudah digunakan oleh warga lain'
            ]);
        }

        // Update data warga
        $updateData = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'alamat' => $this->request->getPost('alamat'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir') ?: null,
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin') ?: null,
            'pekerjaan' => $this->request->getPost('pekerjaan') ?: null,
            'kewarganegaraan' => $this->request->getPost('kewarganegaraan') ?: null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $result = $this->wargaModel->update($wargaId, $updateData);

            if ($result) {
                // Update session data
                $updatedWarga = $this->wargaModel->find($wargaId);
                session()->set('warga', $updatedWarga);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Profil berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui profil'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Profile update error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Upload foto profil
     * Mengupload dan menyimpan foto profil warga
     *
     * Method: POST
     * Route: /profile/upload-photo
     * Akses: Warga yang sudah login
     */
    public function uploadPhoto()
    {
        // Cek apakah user sudah login sebagai warga
        if (!session()->has('warga')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
        }

        $wargaId = session('warga')['id_warga'];

        // Cek apakah ada file yang diupload
        $file = $this->request->getFile('profile_photo');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada file yang dipilih atau file tidak valid'
            ]);
        }

        // Validasi file
        $rules = [
            'profile_photo' => 'uploaded[profile_photo]|max_size[profile_photo,2048]|is_image[profile_photo]|mime_in[profile_photo,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'File tidak valid. Pastikan file berupa gambar (JPG, PNG, WebP) maksimal 2MB',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Generate nama file unik
        $newName = 'profile_' . $wargaId . '_' . time() . '.' . $file->getExtension();

        // Path untuk menyimpan file
        $uploadPath = FCPATH . 'uploads/profiles/';

        // Buat direktori jika belum ada
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Hapus foto lama jika ada
        $oldWarga = $this->wargaModel->find($wargaId);
        if ($oldWarga && $oldWarga['foto_profil'] && file_exists($uploadPath . $oldWarga['foto_profil'])) {
            unlink($uploadPath . $oldWarga['foto_profil']);
        }

        try {
            // Pindahkan file
            if ($file->move($uploadPath, $newName)) {
                // Update database
                $this->wargaModel->update($wargaId, [
                    'foto_profil' => $newName,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                // Update session
                $updatedWarga = $this->wargaModel->find($wargaId);
                session()->set('warga', $updatedWarga);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Foto profil berhasil diperbarui',
                    'photo_url' => base_url('uploads/profiles/' . $newName)
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengupload foto profil'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Photo upload error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Ubah kata sandi
     * Mengubah kata sandi warga
     *
     * Method: POST
     * Route: /profile/change-password
     * Akses: Warga yang sudah login
     */
    public function changePassword()
    {
        // Cek apakah user sudah login sebagai warga
        if (!session()->has('warga')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
        }

        $wargaId = session('warga')['id_warga'];

        // Validation rules
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        $messages = [
            'new_password' => [
                'regex_match' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus'
            ],
            'confirm_password' => [
                'matches' => 'Konfirmasi kata sandi tidak cocok'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Ambil data warga
        $warga = $this->wargaModel->find($wargaId);

        if (!$warga) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data warga tidak ditemukan'
            ]);
        }

        // Verifikasi kata sandi lama
        if (!password_verify($this->request->getPost('current_password'), $warga['password'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kata sandi lama tidak benar'
            ]);
        }

        // Hash kata sandi baru
        $newPasswordHash = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);

        try {
            // Update kata sandi
            $result = $this->wargaModel->update($wargaId, [
                'password' => $newPasswordHash,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kata sandi berhasil diubah'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengubah kata sandi'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Password change error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Hapus foto profil
     * Menghapus foto profil warga
     *
     * Method: POST
     * Route: /profile/delete-photo
     * Akses: Warga yang sudah login
     */
    public function deletePhoto()
    {
        // Cek apakah user sudah login sebagai warga
        if (!session()->has('warga')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
        }

        $wargaId = session('warga')['id_warga'];

        // Ambil data warga
        $warga = $this->wargaModel->find($wargaId);

        if (!$warga || !$warga['foto_profil']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Foto profil tidak ditemukan'
            ]);
        }

        // Hapus file dari server
        $filePath = FCPATH . 'uploads/profiles/' . $warga['foto_profil'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        try {
            // Update database
            $this->wargaModel->update($wargaId, [
                'foto_profil' => null,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Update session
            $updatedWarga = $this->wargaModel->find($wargaId);
            session()->set('warga', $updatedWarga);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Photo delete error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Halaman pengaturan untuk admin/petugas
     * Menampilkan pengaturan profil admin
     *
     * Method: GET
     * Route: /admin/profile
     * Akses: Admin/Petugas yang sudah login
     */
    public function adminProfile()
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $userId = session('user')['id_user'];

        // Ambil data user
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'Data user tidak ditemukan');
        }

        $data = [
            'title' => 'Pengaturan Profil Admin - Sistem Pelayanan Masyarakat',
            'user' => $user,
            'activeTab' => $this->request->getGet('tab') ?? 'profile'
        ];

        return view('profile/admin', $data);
    }

    /**
     * Update profil admin/petugas
     * Mengupdate informasi profil admin
     *
     * Method: POST
     * Route: /admin/profile/update
     * Akses: Admin/Petugas yang sudah login
     */
    public function updateAdminProfile()
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
        }

        $userId = session('user')['id_user'];

        // Validation rules
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'no_telepon' => 'permit_empty|min_length[10]|max_length[15]|regex_match[/^[0-9+\-\s()]+$/]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Cek apakah email sudah digunakan user lain
        $existingUser = $this->userModel
            ->where('email', $this->request->getPost('email'))
            ->where('id_user !=', $userId)
            ->first();

        if ($existingUser) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email sudah digunakan oleh user lain'
            ]);
        }

        // Update data user
        $updateData = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'no_telepon' => $this->request->getPost('no_telepon') ?: null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $result = $this->userModel->update($userId, $updateData);

            if ($result) {
                // Update session data
                $updatedUser = $this->userModel->find($userId);
                session()->set('user', $updatedUser);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Profil berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui profil'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Admin profile update error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Ubah kata sandi admin/petugas
     * Mengubah kata sandi admin
     *
     * Method: POST
     * Route: /admin/profile/change-password
     * Akses: Admin/Petugas yang sudah login
     */
    public function changeAdminPassword()
    {
        // Cek apakah user sudah login sebagai admin/petugas
        if (!session()->has('user')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
        }

        $userId = session('user')['id_user'];

        // Validation rules
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        $messages = [
            'new_password' => [
                'regex_match' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus'
            ],
            'confirm_password' => [
                'matches' => 'Konfirmasi kata sandi tidak cocok'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Ambil data user
        $user = $this->userModel->find($userId);

        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data user tidak ditemukan'
            ]);
        }

        // Verifikasi kata sandi lama
        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kata sandi lama tidak benar'
            ]);
        }

        // Hash kata sandi baru
        $newPasswordHash = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);

        try {
            // Update kata sandi
            $result = $this->userModel->update($userId, [
                'password' => $newPasswordHash,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Kata sandi berhasil diubah'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal mengubah kata sandi'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Admin password change error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ]);
        }
    }
}
