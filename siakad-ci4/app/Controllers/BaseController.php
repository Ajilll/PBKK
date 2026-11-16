<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /** @var CLIRequest|IncomingRequest */
    protected $request;

    protected $helpers = ['url', 'form', 'siakad'];

    protected BaseConnection $db;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
    }

    /** Baris mahasiswa milik user yang sedang login */
    protected function profilMahasiswa(): array
    {
        $row = $this->db->table('mahasiswa')->where('user_id', session('user_id'))->get()->getRowArray();

        return $row ?? throw PageNotFoundException::forPageNotFound();
    }

    /** Baris dosen milik user yang sedang login */
    protected function profilDosen(): array
    {
        $row = $this->db->table('dosen')->where('user_id', session('user_id'))->get()->getRowArray();

        return $row ?? throw PageNotFoundException::forPageNotFound();
    }
}
