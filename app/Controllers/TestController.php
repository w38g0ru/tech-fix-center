<?php

namespace App\Controllers;

class TestController extends BaseController
{
    public function roleSwitcher()
    {
        helper('session');
        
        $data = [
            'title' => 'Role Switcher - Menu Testing'
        ];
        
        return view('test/role_switcher', $data);
    }
    
    public function setRole($role = 'guest')
    {
        helper('session');
        
        $validRoles = ['guest', 'user', 'technician', 'admin', 'super_admin'];
        
        if (in_array(strtolower($role), $validRoles)) {
            if ($role === 'guest') {
                session()->remove('role');
            } else {
                setUserRole($role);
            }
            
            session()->setFlashdata('success', 'Role switched to: ' . ucfirst($role));
        } else {
            session()->setFlashdata('error', 'Invalid role specified');
        }
        
        return redirect()->to(base_url('test/role-switcher'));
    }
    
    public function menuTest()
    {
        helper(['session', 'menu']);

        $data = [
            'title' => 'Menu System Test',
            'current_role' => getUserRole(),
            'menu_html_light' => renderMenuItems('light', true),
            'menu_html_dark' => renderMenuItems('dark', true)
        ];

        return view('test/menu_test', $data);
    }

    public function menuDebug()
    {
        helper(['session', 'menu']);

        $data = [
            'title' => 'Menu Debug'
        ];

        return view('test/menu_debug', $data);
    }
}
