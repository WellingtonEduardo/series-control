<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cover'];

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(
            'ordered',
            function (Builder $queryBuilder) {
                $queryBuilder->orderByRaw('LOWER(name) asc');
            }
        );
    }
}