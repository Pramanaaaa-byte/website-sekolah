<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QRScannerController extends Controller
{
    public function scan(Request $request): JsonResponse
    {
        $request->validate([
            'qr_data' => 'required|string'
        ]);

        try {
            // Decode QR data
            $qrData = json_decode(base64_decode($request->qr_data), true);
            
            if (!$qrData || !isset($qrData['nis'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid'
                ], 400);
            }

            // Find student by NIS
            $siswa = Siswa::where('nis', $qrData['nis'])->first();
            
            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak ditemukan'
                ], 404);
            }

            // Update QR code if not exists
            if (!$siswa->qr_code) {
                $siswa->update([
                    'qr_code' => $request->qr_data,
                    'qr_code_data' => $qrData
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Siswa ditemukan',
                'data' => [
                    'id_siswa' => $siswa->id_siswa,
                    'nis' => $siswa->nis,
                    'nama' => $siswa->nama,
                    'kelas' => $siswa->kelas,
                    'jurusan' => $siswa->jurusan,
                    'total_poin' => $siswa->total_poin
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateQr($id): JsonResponse
    {
        $siswa = Siswa::findOrFail($id);
        
        if (!$siswa->qr_code) {
            $qrData = $siswa->generateQrCode();
            $siswa->update([
                'qr_code' => $qrData,
                'qr_code_data' => json_decode(base64_decode($qrData), true)
            ]);
        }

        return response()->json([
            'success' => true,
            'qr_code' => $siswa->qr_code,
            'siswa' => [
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'kelas' => $siswa->kelas
            ]
        ]);
    }
}
