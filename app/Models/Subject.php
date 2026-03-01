<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    protected $fillable = ['class_id', 'name', 'code', 'type', 'status'];

    public function classYear(): BelongsTo
    {
        return $this->belongsTo(ClassYear::class, 'class_id');
    }

    // Convenience accessors via classYear relationship
    public function getCourseAttribute()
    {
        return $this->classYear?->course;
    }

    public function getDepartmentAttribute()
    {
        return $this->classYear?->course?->department;
    }

    public function getCollegeAttribute()
    {
        return $this->classYear?->course?->department?->college;
    }
}
