<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cooperative extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'initial_member_count',
        'status',
        'created_by',
        'staff_note',
        'reviewed_by',
        'reviewed_at'
    ];

    /**
     * ใครเป็นคนยื่นคำขอสร้างสหกรณ์นี้
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * ใครเป็นคนตรวจสอบ (Staff)
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * รายชื่อสมาชิกในสหกรณ์นี้
     */
    public function members(): HasMany
    {
        return $this->hasMany(CooperativeMember::class);
    }
}
