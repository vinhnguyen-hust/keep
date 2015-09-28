<?php

namespace Keep\Entities\Scopes;

use Carbon\Carbon;

trait TaskScopes
{
    public function scopeUrgent($query)
    {
        return $query
            ->where('priority_id', 1)
            ->where('completed', false)
            ->where('is_failed', false)
            ->oldest('finishing_date');
    }

    public function scopeHigh($query)
    {
        return $query
            ->where('priority_id', 2)
            ->where('completed', false)
            ->where('is_failed', false)
            ->oldest('finishing_date');
    }

    public function scopeNormal($query)
    {
        return $query
            ->where('priority_id', 3)
            ->where('completed', false)
            ->where('is_failed', false)
            ->oldest('finishing_date');
    }

    public function scopeLow($query)
    {
        return $query
            ->where('priority_id', 4)
            ->where('completed', false)
            ->where('is_failed', false)
            ->oldest('finishing_date');
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopeDeadline($query)
    {
        return $query
            ->where('completed', false)
            ->where('is_failed', false)
            ->oldest('finishing_date');
    }

    public function scopeRecentlyCompleted($query)
    {
        return $query
            ->where('completed', true)
            ->latest('finished_at');
    }

    public function scopeAboutToFail($query)
    {
        return $query
            ->where('completed', false)
            ->where('is_failed', false)
            ->where('finishing_date', '<', Carbon::now());
    }

    public function scopeRecentlyFailed($query)
    {
        return $query
            ->where('is_failed', true)
            ->latest('created_at');
    }

    public function scopeDue($query)
    {
        return $query
            ->where('is_failed', false)
            ->where('completed', false);
    }

    public function scopeUpcoming($query)
    {
        return $query
            ->where('completed', false)
            ->where('is_failed', false)
            ->whereBetween('finishing_date', [Carbon::now(), Carbon::now()->addDays(5)]);
    }

    public function scopeSearch($query, $pattern)
    {
        return $query->where('title', 'LIKE', "%$pattern%");
    }
}