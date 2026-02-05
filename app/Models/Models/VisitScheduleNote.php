<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VisitScheduleNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_schedule_id',
        'created_by',
        'note',
        'visit_status',
    ];

    /**
     * Get the agent who created this note
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the visit schedule this note belongs to
     */
    public function visitSchedule()
    {
        return $this->belongsTo(\App\Models\VisitSchedule::class, 'visit_schedule_id');
    }
}
