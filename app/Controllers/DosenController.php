<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;


class DosenController extends ResourceController
{
    protected $modelName = 'App\Models\DosenModel';
    protected $format = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->respond([
            'message' => 'success',
            'data' => $this->model->findAll()
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
        $dosen = $this->model->find($id);
        if (!$dosen) {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }

        return $this->respond([
            'message' => 'success',
            'data' => $dosen
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
        $rules = [
            'nama'  => 'required',
            'nidn'  => 'required',
            'email' => 'required|valid_email',
            'prodi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->request->getJSON(true);
        $this->model->insert($data);

        return $this->respondCreated([
            'message' => 'Data dosen berhasil ditambahkan',
            'data' => $data
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
        $dosen = $this->model->find($id);
        if (!$dosen) {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }

        $rules = [
            'nama'  => 'required',
            'nidn'  => 'required',
            'email' => 'required|valid_email',
            'prodi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->request->getJSON(true);
        $this->model->update($id, $data);

        return $this->respond([
            'message' => 'Data dosen berhasil diupdate',
            'data' => $data
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
        $dosen = $this->model->find($id);
        if (!$dosen) {
            return $this->failNotFound('Data dosen tidak ditemukan');
        }

        $this->model->delete($id);
        return $this->respondDeleted([
            'message' => 'Data dosen berhasil dihapus'
        ]);
    }
}
