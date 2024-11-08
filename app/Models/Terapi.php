<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terapi extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedBy;

    protected $guarded = [];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function scopeOwner(Builder $query)
    {
        if(auth()->user()->is_admin){
            return $query;
        }
        return $query->whereHas('pasien', function($q){
            $q->where('company_id', auth()->user()->company_id);
        });
    }
}
