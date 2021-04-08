<?php

namespace App\Imports;

use App\Models\Schedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DB;

class SchedulesImport implements ToModel, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
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
            if ($row[$i] != NULL) {
                $array[] = array(
                    'id_user' => $row[0],
                    'start' => date_create($row[1] . '-' . sprintf("%02d", $i)),
                    'id_schedule_type' => $row[$i + 1]
                );
            }
        }
        // $insertSchedule->save();
        DB::table('schedules')->insert($array);
    }
}
