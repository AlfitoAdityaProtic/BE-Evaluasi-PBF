<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Config\Database;

class MahasiswaController extends ResourceController
{
    protected $db;
    protected $format = 'json';

    public function __construct()
    {
        $this->db = Database::connect();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $query = $this->db->query("SELECT * FROM mahasiswas");
        $result = $query->getResult();

        return $this->respond([
            'message' => 'success',
            'data_mahasiswa' => $result
        ], 200);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $query = $this->db->query("SELECT * FROM mahasiswas WHERE id = ?", [$id]);
        $row = $query->getRow();

        if ($row === null) {
            return $this->failNotFound("Data Mahasiswa tidak Ditemukan");
        }

        return $this->respond([
            'message' => 'success',
            'mahasiswa_byid' => $row
        ], 200);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = $this->validate([
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required',
            'prodi' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $nama = $this->request->getVar('nama');
        $nim = $this->request->getVar('nim');
        $email = $this->request->getVar('email');
        $prodi = $this->request->getVar('prodi');

        $this->db->query("INSERT INTO mahasiswas(nama, nim, email, prodi) VALUES (?,?,?,?)", [$nama, $nim, $email, $prodi]);

        return $this->respondCreated([
            'message' => 'Data Mahasiswa Berhasil Ditambahkan'
        ]);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $query = $this->db->query("SELECT * FROM mahasiswas WHERE id = ?", [$id]);
        if ($query->getRow() === null) {
            return $this->failNotFound('Data Mahasiswa Tidak Ditemukan');
        }

        $rules = $this->validate([
            'nama'  => 'required',
            'nim'  => 'required',
            'email' => 'required|valid_email',
            'prodi' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $nama = $this->request->getVar('nama');
        $nim = $this->request->getVar('nim');
        $email = $this->request->getVar('email');
        $prodi = $this->request->getVar('prodi');

        $this->db->query("UPDATE mahasiswas SET nama = ?, nim = ?, email = ?, prodi = ? WHERE id = ?", [$nama, $nim, $email, $prodi, $id]);

        return $this->respond([
            'message' => 'Data Mahasiswa berhasil diubah'
        ]);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $query = $this->db->query("SELECT * FROM mahasiswas WHERE id = ?", [$id]);
        if ($query->getRow() === null) {
            return $this->failNotFound('Data Mahasiswa Tidak Ditemukan');
        }
        $this->db->query("DELETE FROM mahasiswas WHERE id = ?", [$id]);

        return $this->respondDeleted([
            'message' => 'Data Mahasiswa Berhasil Dihapus'
        ]);
    }
}
