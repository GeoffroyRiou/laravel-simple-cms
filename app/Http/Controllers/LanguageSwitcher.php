<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageSwitcher extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        session(['locale' => $request->get('locale')]);
        return redirect('/');
    }
}
