<?php

namespace App\Imports;

use App\Models\Schedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
// use Illuminate\Contracts\Queue\ShouldQueue; //IMPORT SHOUDLQUEUE
// use Maatwebsite\Excel\Concerns\WithChunkReading; //IMPORT CHUNK READING

use DB;
// , WithChunkReading, ShouldQueue
class SchedulesImport implements ToModel, WithStartRow
{
    private $month;

    public function __construct(String $month)
    {
        $this->month = $month;
    }
    
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 3;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $array = array();
        for ($i = 1; $i <= 31; $i++) {
            $array[] = array(
                'nip' => $row[0],
                'id_schedule_type' => $row[$i],
                'start' => date_create($this->month . '-' . sprintf("%02d", $i)),
                'is_open' => 0,
            );
        }

        // dd($array);
        // die;
        // $insertSchedule->save();
        DB::table('schedules')->insert($array);
    }

    //LIMIT CHUNKSIZE
    // public function chunkSize(): int
    // {
    //     return 1000; //ANGKA TERSEBUT PERTANDA JUMLAH BARIS YANG AKAN DIEKSEKUSI
    // }
}
