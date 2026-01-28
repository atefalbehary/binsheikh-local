<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'client_name',
        'email',
        'country_code',
        'phone',
        'project_id',
        'nationality',
        'apartment_no',
        'apartment_type',
    ];

    /**
     * Get the agent/user who registered this client
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get the project associated with this client
     */
    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }
}
