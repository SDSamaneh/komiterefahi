<?php

namespace App\Models\dashboard;

use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imprest extends Model
{
    protected $fillable = [
        'author_id',
        'name',
        'idCard',
        'price',
        'loc',
        'status',
        'accept',
        'finalPrice',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function departmans(): BelongsTo
    {
        return $this->belongsTo(Departmans::class, 'departmans_id');
    }

    // و همچنین هر وام مرتبط است به یک مدیر واحد (اختیاری)
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisors_id');
    }
}
