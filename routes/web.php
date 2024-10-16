<?php

use App\Models\Contact;
use Illuminate\Support\Facades\Route;

require_once __DIR__ . '/verbs.php';
require_once __DIR__ . '/event_sauce.php';


Route::get('/contact/{contact}', function(Contact $contact) {
    return view('contact', ['contact' => $contact]);
});







Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/{user_id}', function($user_id) {
    auth()->loginUsingId($user_id);
    return redirect('/verbs/contact/2');
});

