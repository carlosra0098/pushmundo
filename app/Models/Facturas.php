<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
        'archivo_pdf',
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
