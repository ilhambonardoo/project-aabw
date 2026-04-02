<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should return the request object, or a response object.
     * If it returns a response object, the execution of the script will stop and the
     * response will be sent to the browser.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silahkan login terlebih dahulu.');
        }
        
        if ($arguments) {
            $userRole = session()->get('role');
            
            $argumentsLower = array_map('strtolower', array_map('trim', $arguments));
            $userRoleLower = strtolower(trim($userRole));

            if (!in_array($userRoleLower, $argumentsLower)) {
                
                return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut. (Role Anda saat ini: ' . $userRole . ')');
            }
        }

        if (empty($arguments)) {
            return;
        }

    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow stopping
     * the execution of other after filters.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
