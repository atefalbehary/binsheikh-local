<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiteSchedule extends Model
{
    use HasFactory;

    protected $table = 'visit_schedules';

    protected $fillable = [
        'agent_id',
        'client_name',
        'client_phone_number',
        'client_email_address',
        'visit_time',
        'client_id',
        'project_id',
        'unit_type',
        'notes',
        'visit_purpose',
    ];

    protected $casts = [
        'visit_time' => 'datetime',
    ];

    /**
     * Get the agent (user) that owns the visit schedule.
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get the project that the visit is scheduled for.
     */
    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }
}
