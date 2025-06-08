<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\JwtHelper;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    protected $format = 'json';

    public function register()
    {
        $data = $this->request->getJSON();
        $userModel = new UserModel();

        // Validasi field
        if (!$data || !isset($data->NPM, $data->nama_lengkap, $data->password)) {
            return $this->fail('Field tidak lengkap', 400);
        }

        // Cek apakah NPM sudah ada
        if ($userModel->where('NPM', $data->NPM)->first()) {
            return $this->fail('NPM sudah terdaftar', 409);
        }

        // Simpan user
        $userModel->insert([
            'NPM'          => $data->NPM,
            'nama_lengkap' => $data->nama_lengkap,
            'password'     => password_hash($data->password, PASSWORD_DEFAULT)
        ]);

        return $this->respondCreated(['message' => 'Register berhasil']);
    }

    public function login()
    {
        $data = $this->request->getJSON();
        $userModel = new UserModel();
        $jwt = new JwtHelper();

        if (!$data || !isset($data->NPM, $data->password)) {
            return $this->fail('Field tidak lengkap', 400);
        }

        $user = $userModel->where('NPM', $data->NPM)->first();

        if (!$user) {
            return $this->failUnauthorized('NPM tidak ditemukan');
        }

        if (!password_verify($data->password, $user['password'])) {
            return $this->failUnauthorized('Password salah');
        }

        // Generate JWT
        $token = $jwt->encode([
            'NPM' => $user['NPM'],
            'nama_lengkap' => $user['nama_lengkap']
        ]);

        return $this->respond([
            'message' => 'Login berhasil',
            'token' => $token
        ]);
    }
}
