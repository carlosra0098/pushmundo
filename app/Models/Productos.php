<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo de Productos
 * Gestiona los datos de los productos
 */
class Productos extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'proveedor_id',
        'stock',
        'codigo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
    ];

    public $timestamps = true;

    public function proveedor()
    {
        return $this->belongsTo(Proveedores::class, 'proveedor_id');
    }

    public function getNombreConPrecioAttribute()
    {
        return "{$this->nombre} ({$this->precio})";
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nombre', 'like', "%{$search}%")
                     ->orWhere('codigo', 'like', "%{$search}%");
    }
}
