<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTerapi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
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
