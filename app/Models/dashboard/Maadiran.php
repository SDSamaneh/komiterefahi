<?php

namespace App\Models\dashboard;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Maadiran extends Model
{
    protected $fillable = [
        'author_id',
        'name',
        'idCard',
        'departmans_id',
        'supervisors_id',
        'price',
        'descriptionUser',
        'category',
        'accept',
        'status',
        'memberDate',
        'memberPrice',
        'lastSalary',
        'debt_company',
        'debt_madiran',
        'debt_fund',
        'debt_purchase',
        'validationDate',
        'descriptionEdari',
        'descriptionHr',
        'validationHr',
        'validation_managerHr',
    ];


    public function departmans(): BelongsTo
    {
        return $this->belongsTo(Departmans::class, 'departmans_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // و همچنین هر وام مرتبط است به یک مدیر واحد (اختیاری)
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisors_id');
    }
}
