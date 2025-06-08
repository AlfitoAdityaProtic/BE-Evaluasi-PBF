<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Config\Database;

class DosenController extends ResourceController
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
        $query = $this->db->query("SELECT * FROM dosens");
        $result = $query->getResult();

        return $this->respond([
            'message' => 'success',
            'data_dosen' => $result
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
        $query = $this->db->query("SELECT * FROM dosens WHERE id = ?", [$id]);
        $row = $query->getRow();

        if ($row === null) {
            return $this->failNotFound('Data Dosen tidak ditemukan');
        }

        return $this->respond([
            'message' => 'success',
            'dosen_byid' => $row
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
            'nama'  => 'required',
            'nidn'  => 'required',
            'email' => 'required|valid_email',
            'prodi' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }
        $nama  = $this->request->getVar('nama');
        $nidn  = $this->request->getVar('nidn');
        $email = $this->request->getVar('email');
        $prodi = $this->request->getVar('prodi');

        $this->db->query("INSERT INTO dosens(nama, nidn, email, prodi) VALUES(?,?,?,?)", [$nama, $nidn, $email, $prodi]);

        return $this->respondCreated([
            'message' => 'Data Dosen berhasil Ditambahkan'
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
        $query = $this->db->query("SELECT * FROM dosens WHERE id = ?", [$id]);
        if ($query->getRow() === null) {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }

        $rules = $this->validate([
            'nama'  => 'required',
            'nidn'  => 'required',
            'email' => 'required|valid_email',
            'prodi' => 'required',
        ]);

        if (!$rules) {
            return $this->failValidationErrors([
                'message' => $this->validator->getErrors()
            ]);
        }

        $nama  = $this->request->getVar('nama');
        $nidn  = $this->request->getVar('nidn');
        $email = $this->request->getVar('email');
        $prodi = $this->request->getVar('prodi');

        $this->db->query("UPDATE dosens SET nama = ?, nidn = ?, email = ?, prodi = ? WHERE id = ?", [$nama, $nidn, $email, $prodi, $id]);

        return $this->respond([
            'message' => 'Data dosen berhasil diubah'
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
        $query = $this->db->query("SELECT * FROM dosens WHERE id = ?", [$id]);
        if ($query->getRow() === null) {
            return $this->failNotFound('Data Dosen Tidak Ditemukan');
        }
        $this->db->query("DELETE FROM dosens WHERE id = ?", [$id]);

        return $this->respondDeleted([
            'message' => 'Data Dosen Berhasil Dihapus'
        ]);
    }
}
