<?php

namespace Modules\Numbers\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher;

class NumbersController extends Controller
{
    /**
     * Create new report
     * Redirect to show
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start()
    {
        return \redirect(route('numbers.show'));
    }

    public function end()
    {
        return \redirect(route('home'));
    }

    public function show()
    {
        return view('numbers::numbers', []);
    }
}
