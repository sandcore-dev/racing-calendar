<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Lang;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected string $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')
            ->except('logout');
    }

    public function showLoginForm(): Response
    {
        return Inertia::render(
            'Login',
            [
                'title' => Lang::get('Login'),

                'labels' => [
                    'email' => Lang::get('E-mail address'),
                    'password' => Lang::get('Password'),
                    'submit' => Lang::get('Login'),
                ]
            ]
        );
    }
}
