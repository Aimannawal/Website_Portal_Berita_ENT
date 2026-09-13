<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardRedirectController extends Controller
{
    public function redirect()
    {
        $user = Auth::user();

        if ($user->hasRole('webmaster')) {
            return redirect()->route('wm.dashboard');
        }

        if ($user->hasRole('perencanaan_konten')) {
            return redirect()->route('pk.dashboard');
        }

        return redirect()->route('divisi.dashboard');
    }
}
