<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
        'imagen',
        'archivo_pdf',
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

    public function getImagenUrlAttribute(): ?string
    {
        if (empty($this->imagen)) {
            return null;
        }

        $path = ltrim((string) $this->imagen, '/');
        $path = str_replace('\\', '/', $path);

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'storage/')) {
            return '/' . $path;
        }

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7);
        }

        return '/storage/' . ltrim($path, '/');
    }

    public function getArchivoPdfUrlAttribute(): ?string
    {
        if (empty($this->archivo_pdf)) {
            return null;
        }

        $path = ltrim((string) $this->archivo_pdf, '/');
        $path = str_replace('\\', '/', $path);

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'storage/')) {
            return '/' . $path;
        }

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7);
        }

        return '/storage/' . ltrim($path, '/');
    }
}
