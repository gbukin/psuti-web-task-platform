<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class WebTasksController extends Controller
{
    public function taskPasswordIndex()
    {
        return Inertia::render('WebTasks/Password/Index');
    }

    public function taskBypassIndex()
    {
        setcookie('user-role', 'user', time() + 3600 * 24);
        return Inertia::render('WebTasks/Bypass/Index');
    }

    public function taskBypassCheckPassword(Request $request)
    {
        if ($request->post('password') !== 'p@$$w0rd') {
            $message = 'Passwords does not match!';
            return response()->json(['message' => $message, 'success' => false]);
        }

        if ($_COOKIE['user-role'] !== 'admin') {
            $message = 'You have not permissions to access this data!';
            return response()->json(['message' => $message, 'success' => false]);
        }

        $x_real_ip = $request->header('X-Real-IP');

        if (empty($x_real_ip)) {
            $message = 'Detected hacking attempt! You ip do not satisfy your request!';
            return response()->json(['message' => $message, 'success' => false]);
        }

        if (str_starts_with($x_real_ip, '10.') || str_starts_with($x_real_ip, '192.168.') || $x_real_ip === '127.0.0.1') {
            $message = 'Yor flag: PSUTI-CTF{Y0U-@R3-GR3@t-H@ck3R}';
            $success = true;
        } else {
            $message = 'Detected hacking attempt! You ip do not satisfy your request!';
            $success = false;
        }

        return response()->json(['message' => $message, 'success' => $success]);
    }
}
