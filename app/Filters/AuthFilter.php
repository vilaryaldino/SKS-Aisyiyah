<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/')->with('swal_error', 'Silakan login terlebih dahulu.');
        }

        // Optional: Check for 'admin' role if strict restriction is needed on specific routes
        // For now, we rely on the Controller/Dashboard separation, but we could add role checks here.
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing here
    }
}
