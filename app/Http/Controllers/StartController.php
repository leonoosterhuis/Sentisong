<?php

namespace App\Http\Controllers;

use App\Models\Music_Quotes;
use AppHelper;

use function App\Helpers\dumps;
use function App\Helpers\viewEngine;
use function Symfony\Component\String\s;

class StartController extends Controller
{

    public function index(){
        $result = Music_Quotes::inRandomOrder()->first()->quote;
        $data['randomQuote'] = $result;
        viewEngine('home', $data);
    }

}
