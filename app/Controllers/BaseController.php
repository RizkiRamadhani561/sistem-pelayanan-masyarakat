<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Kelas BaseController
 *
 * BaseController menyediakan tempat yang praktis untuk memuat komponen
 * dan menjalankan fungsi yang dibutuhkan oleh semua controller.
 * Perluas kelas ini di controller baru:
 *     class Home extends BaseController
 *
 * Untuk keamanan, pastikan mendeklarasikan method baru sebagai protected atau private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance dari objek Request utama.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Array helper yang akan dimuat otomatis saat
     * instansiasi kelas. Helper ini akan tersedia
     * untuk semua controller yang mewarisi BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Pastikan mendeklarasikan properti untuk setiap properti dinamis yang diinisialisasi.
     * Pembuatan properti dinamis sudah tidak direkomendasikan di PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Jangan Edit Baris Ini
        parent::initController($request, $response, $logger);

        // Muat model, library, dll di sini jika diperlukan.

        // Contoh: $this->session = service('session');
    }
}
