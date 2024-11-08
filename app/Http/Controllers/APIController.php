<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Pasien;
use App\Models\Perangkat;
use App\Models\RiwayatTerapi;
use App\Models\RiwayatTerapiDetail;
use App\Models\Terapi;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function cekPerangkat($sn_perangkat)
    {
        $perangkat = Perangkat::where('serial_number', $sn_perangkat)->first();
        if ($perangkat) {
            return response()->json([
                'ip_internal_company' => $perangkat->company->ip_internal,
            ]);
        } else {
            abort(404);
        }
    }

    public function daftarPasien($sn_perangkat)
    {
        $perangkat = Perangkat::where('serial_number', $sn_perangkat)->first();
        if ($perangkat) {
            $terapi = Terapi::whereHas('pasien', function ($q) use ($perangkat) {
                $q->where('company_id', $perangkat->company_id);
            })
                ->whereDate('tgl_terapi', date('Y-m-d'))
                ->get();
            //get list pasien of terapi
            $list_pasien = [];
            foreach ($terapi as $t) {

                //if list list pasien is already contain pasien, then skip
                if (in_array($t->pasien->id, array_column($list_pasien, 'id'))) {
                    continue;
                }

                $list_pasien[] = [
                    'id' => $t->pasien->id,
                    'nama' => $t->pasien->nama,
                ];
            }

            return response()->json([
                'status' => 'success',
                'data' => $list_pasien,
            ]);
        } else {
            abort(404);
        }
    }

    public function setHistoryTerapi($sn_perangkat, $id_pasien, $kode_game, $point, $waktu, $jarak)
    {
        $perangkat = Perangkat::where('serial_number', $sn_perangkat)->first();
        if ($perangkat) {
            RiwayatTerapiDetail::create([
                'pasien_id' => $id_pasien,
                'kode_game' => $kode_game,
                'point' => $point,
                'waktu' => $waktu,
                'jarak' => $jarak,
            ]);
            return response()->json([
                'status' => 'success',
            ]);
        } else {
            abort(404);
        }
    }

    public function stopTerapi($sn_perangkat, $id_pasien, $kode_game)
    {
        $perangkat = Perangkat::where('serial_number', $sn_perangkat)->first();
        if ($perangkat) {
            $allRiwayatTerapi = RiwayatTerapiDetail::where('pasien_id', $id_pasien)
                ->where('kode_game', $kode_game)
                ->where('is_done', false)
                ->get();
            $latestRiwayatTerapiDetail = $allRiwayatTerapi->last();
            if ($latestRiwayatTerapiDetail) {
                //set is_done to true
                $allRiwayatTerapi->each(function ($item, $key) {
                    $item->is_done = true;
                    $item->save();
                });
                $sumPoint = $allRiwayatTerapi->sum('point');
                $sumWaktu = $allRiwayatTerapi->sum('waktu');
                $sumJarak = $allRiwayatTerapi->sum('jarak');
                $terapi = Terapi::where('pasien_id', $id_pasien)
                    ->whereDate('tgl_terapi', date('Y-m-d'))
                    ->latest()
                    ->first();
                $game = Game::where('kode', $kode_game)->first();
                RiwayatTerapi::create([
                    'terapi_id' => $terapi->id,
                    'game_id' => $game->id,
                    'pasien_id' => $id_pasien,
                    'tgl_terapi' => date('Y-m-d'),
                    'lama_terapi' => $sumWaktu,
                    'point' => $sumPoint,
                    'jarak' => $sumJarak,
                ]);
                return response()->json([
                    'status' => 'success',
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                ]);
//                abort(404);
            }


        } else {
            abort(404);
        }

    }
}
