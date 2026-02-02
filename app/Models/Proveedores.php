<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo de Proveedores
 */
class Proveedores extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'contacto',
        'email',
        'telefono',
        'direccion',
    ];

    public $timestamps = true;

    public function productos()
    {
        return $this->hasMany(Productos::class, 'proveedor_id');
    }

    protected static function booted()
    {
        static::deleting(function ($proveedor) {
            // Desvincular productos cuando se elimine el proveedor (soft o force)
            $proveedor->productos()->update(['proveedor_id' => null]);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nombre', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%");
    }
}
