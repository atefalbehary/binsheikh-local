<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'agent_id',
        'status',
        'commission'
    ];

    protected $casts = [
        'commission' => 'decimal:2',
    ];

    // Status constants
    const STATUS_WAITING_APPROVAL = 'waitingApproval';
    const STATUS_RESERVED = 'Reserved';
    const STATUS_PREPARING_DOCUMENT = 'PreparingDocument';
    const STATUS_CLOSED_DEAL = 'ClosedDeal';

    // Get all available statuses
    public static function getStatuses()
    {
        return [
            self::STATUS_WAITING_APPROVAL => 'Waiting Approval',
            self::STATUS_RESERVED => 'Reserved',
            self::STATUS_PREPARING_DOCUMENT => 'Preparing Document',
            self::STATUS_CLOSED_DEAL => 'Closed Deal'
        ];
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    // Get status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            self::STATUS_WAITING_APPROVAL => 'badge-warning',
            self::STATUS_RESERVED => 'badge-info',
            self::STATUS_PREPARING_DOCUMENT => 'badge-primary',
            self::STATUS_CLOSED_DEAL => 'badge-success',
            default => 'badge-secondary'
        };
    }

    /**
     * Get the property that owns the reservation.
     */
    public function property()
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }

    /**
     * Get the agent (user) that owns the reservation.
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by agent
     */
    public function scopeByAgent($query, $agentId)
    {
        return $query->where('agent_id', $agentId);
    }

    /**
     * Scope for filtering by property
     */
    public function scopeByProperty($query, $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }
}