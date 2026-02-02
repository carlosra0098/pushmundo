<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo de Facturas
 */
class Facturas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'facturas';

    protected $fillable = [
        'numero',
        'cliente_id',
        'total',
        'fecha',
        'estado',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'fecha' => 'datetime',
    ];

    public $timestamps = true;

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('numero', 'like', "%{$search}%")
                     ->orWhere('estado', 'like', "%{$search}%");
    }
}
