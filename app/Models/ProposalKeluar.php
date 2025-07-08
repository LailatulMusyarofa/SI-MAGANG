<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalKeluar extends Model
{
    protected $table = 'proposal_keluar'; 
    protected $fillable = [
        'id_sklh',
        'nomor_surat_permintaan',
        'tanggal_surat_permintaan',
        'perihal_surat_permintaan',
        'ditandatangani_oleh',
        'scan_surat_permintaan',
        'scan_proposal_magang',
    ];
}