<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NotificationTemplateController extends Controller
{
    public function index()
    {
        return view('admin.notification-templates');
    }
}
