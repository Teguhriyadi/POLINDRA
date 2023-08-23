<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "laporan_kegiatan";

    protected $guarded = [''];

    public $incrementing = false;

    protected $keyType = "string";

    public $primaryKey = "id";

    public function izin()
    {
        return $this->hasOne("App\Models\IzinKegiatan", "id", "izin_kegiatan_id");
    }
}
