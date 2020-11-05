<?php

namespace Yusronarif\Core\Database\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps as BaseHasTimestamps;

trait HasTimestamps
{
    use BaseHasTimestamps;

    /**
     * Set the value of the "created at" attribute.
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setCreatedAt($value)
    {
        if (auth()->check()) {
            if ($this->performerMode == 'users')
                $this->performBy = auth()->user()->id;
            else
                $this->performBy = auth()->user()->name ?? auth()->user()->username ?? auth()->user()->email ?? auth()->user()->id;
        }

        $this->{$this->getCreatedAtColumn()} = $value;
        $this->{$this->getCreatedByColumn()} = $this->performBy;

        return $this;
    }

    /**
     * Set the value of the "updated at" attribute.
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setUpdatedAt($value)
    {
        if (auth()->check()) {
            if ($this->performerMode == 'users')
                $this->performBy = auth()->user()->id;
            else
                $this->performBy = auth()->user()->name ?? auth()->user()->username ?? auth()->user()->email ?? auth()->user()->id;
        }

        $this->{$this->getUpdatedAtColumn()} = $value;
        $this->{$this->getUpdatedByColumn()} = $this->performBy;

        return $this;
    }

    /**
     * Get the name of the "created by" column.
     *
     * @return string
     */
    public function getCreatedByColumn()
    {
        return defined('static::CREATED_BY') ? static::CREATED_BY : 'created_by';
    }

    /**
     * Get the name of the "updated by" column.
     *
     * @return string
     */
    public function getUpdatedByColumn()
    {
        return defined('static::UPDATED_BY') ? static::UPDATED_BY : 'updated_by';
    }

    public function creater()
    {
        return $this->belongsTo(config('yusronarifCore.model.users'), $this->getCreatedByColumn());
    }

    public function updater()
    {
        return $this->belongsTo(config('yusronarifCore.model.users'), $this->getUpdatedByColumn());
    }
}
