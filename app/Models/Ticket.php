<?php

namespace App\Models;

use Coderflex\LaravelTicket\Models\Ticket as Ticket1;
use Illuminate\Database\Eloquent\Model;
use App\Models\SpecificCategory;
use App\Models\QuestionCategory;
use App\Models\User;
use App\Models\GroupCompany;
use App\Models\Company;



class Ticket extends Ticket1
{
    // public function specificCategory()
    // {
    //     return $this->belongsTo(SpecificCategory::class);
    // }
    // public function questionCategory()
    // {
    //     return $this->belongsTo(QuestionCategory::class);
    // }
    public function assignedTo()
    {
        return $this->belongsTo(User::class);
    }
    // public function groupCompany()
    // {
    //     return $this->belongsTo(GroupCompany::class);
    // }
    // public function company()
    // {
    //     return $this->belongsTo(Company::class);
    // }
}