<?php

namespace App\Controllers;

use App\Models\PetModel;

class AuthController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $session = session();
        $db = \Config\Database::connect();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role'); // admin veya customer

        // Kullanıcıyı veritabanında ara
        $user = $db->table('users')
                   ->where('username', $username)
                   ->where('password', $password)
                   ->where('role', $role)
                   ->get()
                   ->getRowArray();

        if ($user) {
            // Oturum bilgilerini kaydet
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'pet_id' => $user['pet_id'],
                'isLoggedIn' => true
            ]);

            // Rolü admin (veteriner) ise tam listeye yönlendir
            if ($user['role'] === 'admin') {
                return redirect()->to('/pet');
            } else {
                // Rolü müşteriyse direkt kendi hayvanının detay sayfasına yönlendir!
                return redirect()->to('/pet/view/' . $user['pet_id']);
            }
        } else {
            $session->setFlashdata('error', 'Hatalı kullanıcı adı, şifre veya yetki seçimi!');
            return redirect()->to('/auth');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}