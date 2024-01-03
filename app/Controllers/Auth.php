<?php

namespace App\Controllers;

use App\Models\AuthModel;
use Config\Services;

helper('form');
class Auth extends BaseController
{
    public function index()
    {
        $data["error"] = "";
        $session = session();
        $validation = \Config\Services::validation();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $validation->setRule('email', 'Email', 'required|valid_email');
            $validation->setRule('password', 'Password', 'required');
            if ($validation->withRequest($this->request)->run() == TRUE) {
                $email = $this->request->getVar('email');
                $password = $this->request->getVar('password');
                $rememberMe = "";
                if (isset($_POST['rememberMe'])) {
                    $rememberMe = sha1(rand(100000, 999999));
                }
                $auth = new AuthModel();
                $validate = $auth->authenticate($email, $password);
                if ($validate) {
                    if ($rememberMe != "") {
                        set_cookie('rememberMe', $rememberMe);
                        $auth->updateRememberMeToken($rememberMe);
                    }

                    return redirect()->to(site_url('/dashboard'));
                } else {
                    $data['error'] = "Invalid Credentials";
                    return view('login', $data);
                }
            } else {
                $data['error'] = "Invalid Credentials";
                return view('login', $data);
            }
        } else {
            return view('login', $data);
        }
    }
}
