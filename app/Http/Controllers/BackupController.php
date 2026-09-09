<?php

// app/Http/Controllers/BackupController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class BackupController extends Controller
{
    public function backup()
    {
        // Konfigurasi database
        $dbHost = env('DB_HOST');
        $dbPort = env('DB_PORT', '3306');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbName = env('DB_DATABASE');

        // Nama file backup
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $path = storage_path("app/backups/$filename");

        // Pastikan folder backups ada
        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump.exe';
        $command = "\"$mysqldumpPath\" --single-transaction -h $dbHost -P $dbPort -u $dbUser " .
            (!empty($dbPass) ? "-p$dbPass " : "") .
            "$dbName > \"$path\"";

        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result !== 0) {
            return back()->with('error', 'Gagal melakukan backup. Cek konfigurasi database atau akses mysqldump.');
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
