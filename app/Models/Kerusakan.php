<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    public const JENIS_KERUSAKAN = [
        'Ringan',
        'Sedang',
        'Berat',
        'Tidak Bisa Digunakan',
    ];

    protected $fillable = [
        'peralatan_id',
        'user_id',
        'jenis_kerusakan',
        'deskripsi',
        'foto',
        'status',
        'tanggal',
    ];

    public static function countByJenis(): array
    {
        return collect(self::JENIS_KERUSAKAN)
            ->mapWithKeys(fn (string $jenis) => [
                $jenis => static::where('jenis_kerusakan', $jenis)->count(),
            ])
            ->all();
    }

    public static function countByLaboratorium(array $lokasiLab): array
    {
        return collect($lokasiLab)
            ->mapWithKeys(fn (string $lokasi) => [
                $lokasi => static::whereHas('user', fn (Builder $query) => $query->where('lokasi_lab', $lokasi))->count(),
            ])
            ->all();
    }

    public function scopeWithPeralatan(Builder $query): Builder
    {
        return $query->with('peralatan');
    }

    public function scopeWithReportRelations(Builder $query): Builder
    {
        return $query->with(['peralatan', 'user']);
    }

    public function scopeFilterLaporan(Builder $query, array $filter): Builder
    {
        return $query
            ->when($filter['tanggal_mulai'] ?? null, fn (Builder $query, string $tanggalMulai) => $query->whereDate('tanggal', '>=', $tanggalMulai))
            ->when($filter['tanggal_selesai'] ?? null, fn (Builder $query, string $tanggalSelesai) => $query->whereDate('tanggal', '<=', $tanggalSelesai))
            ->when($filter['laboratorium'] ?? null, function (Builder $query, string $laboratorium) {
                $query->whereHas('user', fn (Builder $userQuery) => $userQuery->where('lokasi_lab', $laboratorium));
            })
            ->when($filter['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filter['kategori'] ?? null, fn (Builder $query, string $kategori) => $query->where('jenis_kerusakan', $kategori));
    }

    public function peralatan()
    {
        return $this->belongsTo(
            Peralatan::class
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
}
