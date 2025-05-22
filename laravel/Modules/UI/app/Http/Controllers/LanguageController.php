<?php

declare(strict_types=1);

namespace Modules\UI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageController extends Controller
{
    /**
     * Cambia la lingua dell'applicazione.
     */
    public function switch($locale)
    {
        if (!in_array($locale, LaravelLocalization::getSupportedLocalesKeys())) {
            $locale = LaravelLocalization::getDefaultLocale();
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);

        return redirect()->back();
    }
}
