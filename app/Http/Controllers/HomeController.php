<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $wishes = Wish::all(); // Lấy lời chúc từ DB
return view('home', compact('wishes'));
        // Trả về file giao diện: resources/views/welcome.blade.php
        return view('welcome'); 
    }
    public function chooseTemplate()
{
    // Lấy toàn bộ 7 mẫu từ Database
    $templates = \App\Models\Template::where('is_active', 1)->get();

    return view('client.choose-template', compact('templates'));
}

}
