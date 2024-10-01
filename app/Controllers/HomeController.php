<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
      return view('test', ['name' => 'John2', 'age' => 35],'default_dark');
    }

    public function contact()
    {
        return 'Contact page';
    }

}