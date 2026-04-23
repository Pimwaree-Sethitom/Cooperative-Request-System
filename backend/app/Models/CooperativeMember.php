<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CooperativeMember extends Model
{
    use HasFactory;

    // เนื่องจากเราไม่ใช้ timestamps (created_at, updated_at) แบบมาตรฐาน 
    // แต่เรามีแค่ created_at ใน Migration เราจึงต้องปิดการทำงานอัตโนมัติ
    public $timestamps = false;

    protected $fillable = [
        'cooperative_id',
        'full_name',
        'national_id',
        'phone'
    ];

    /**
     * สมาชิกคนนี้สังกัดสหกรณ์ไหน
     */
    public function cooperative(): BelongsTo
    {
        return $this->belongsTo(Cooperative::class);
    }
}
