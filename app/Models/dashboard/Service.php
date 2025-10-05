<?php

namespace App\Models\dashboard;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $fillable = [
        'author_id',
        'name',
        'idCard',
        'departmans_id',
        'supervisors_id',
        'category',
        'price',
        'descriptionUser',
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
        'number',
        'descriptionEdari',
        'descriptionHr',
        'validationHr',
        'validation_managerHr',
        'descriptionManager1',
        'validationManager1',
        'finalPrice',
        'descriptionManager2',
        'validationManager2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function departmans(): BelongsTo
    {
        return $this->belongsTo(Departmans::class, 'departmans_id');
    }
    public function supervisors(): BelongsTo
    {
        return $this->belongsTo(Supervisor::class, 'supervisors_id');
    }
}
