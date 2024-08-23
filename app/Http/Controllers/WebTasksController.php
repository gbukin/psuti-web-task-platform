<?php

namespace App\Http\Controllers;

use App\Jobs\RedeemCertificate;
use App\Models\ShopUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
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
        $message = '';

        if ($request->post('password') !== 'p@$$w0rd') {
            $message = 'Passwords does not match!';
        }

        if ($_COOKIE['user-role'] !== 'admin') {
            $message = 'You have not permissions to access this data!';
        }

        $x_real_ip = $request->header('X-Real-IP');

        if (empty($x_real_ip)) {
            $message = 'Detected hacking attempt! You ip do not satisfy your request!';
        }

        if ($message !== '') {
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

    public function taskShopIndex()
    {
        $account = null;

        $token = !empty($_COOKIE['shop-token']) ? $_COOKIE['shop-token'] : null;

        if (!empty($token)) {
            $account = ShopUser::where([
                'token' => $token,
            ])->first();

            if (empty($account)) {
                Cookie::queue('shop-token', '', time() - 3600);
            }
        }

        return Inertia::render('WebTasks/Store/Index', ['account' => $account]);
    }

    public function taskShopCreateAccount(Request $request)
    {
        $token = !empty($_COOKIE['shop-token']) ? $_COOKIE['shop-token'] : null;

        if (!empty($token)) {
            return response()->json(['status' => 400, 'message' => 'Вы уже авторизованы!']);
        }

        $email = $request->post('email');
        $password = $request->post('password');

        $token = hash('sha256', $email.$password);

        $account = ShopUser::where('token', $token)->first();

        if (is_null($account)) {
            $account = new ShopUser();
            $account->email = $email;
            $account->password = $password;
            $account->token = $token;
            $account->save();
        }

        Cookie::queue('shop-token', $token, 60 * 24);

        return response()->json(['status' => 200, 'message' => 'OK']);
    }

    public function taskShopRedeemCertificate()
    {
        $token = !empty($_COOKIE['shop-token']) ? $_COOKIE['shop-token'] : null;

        if (empty($token)) {
            return response()->json(['status' => 400, 'message' => 'Требуется авторизация']);
        }

        $account = ShopUser::where('token', $token)->first();

        if ($account->redeemCertificate) {
            return response()->json(['status' => 400, 'message' => 'Сертификат уже активирован']);
        }

        RedeemCertificate::dispatch($account);

        return response()->json(['status' => 200, 'message' => 'OK']);
    }

    public function taskShopRefundCertificate()
    {
        $token = !empty($_COOKIE['shop-token']) ? $_COOKIE['shop-token'] : null;

        if (empty($token)) {
            return response()->json(['status' => 400, 'message' => 'Требуется авторизация']);
        }

        $account = ShopUser::where('token', $token)->first();

        if (!$account->redeemCertificate) {
            return response()->json(['status' => 400, 'message' => 'Сертификат не был погашен и не может быть возвращен']);
        }

        $account->balance -= 200;
        $account->redeemCertificate = false;
        $account->save();

        return response()->json(['status' => 200, 'message' => 'OK']);
    }

    public function taskShopBuyFlag()
    {
        $token = !empty($_COOKIE['shop-token']) ? $_COOKIE['shop-token'] : null;

        if (empty($token)) {
            return response()->json(['status' => 400, 'message' => 'Требуется авторизация']);
        }

        $account = ShopUser::where('token', $token)->first();

        if ($account->balance < 500) {
            return response()->json(['status' => 400, 'message' => 'На счете недостаточно средств']);
        }

        $account->balance -= 500;
        $account->save();

        return response()->json(['status' => 200, 'message' => 'PSUTI-CTF{R@c3-C0nD1t10N@L-$Ucc3$$-P@$$3D}']);
    }
}
