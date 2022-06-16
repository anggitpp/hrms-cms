<?php

namespace App\Exports\Attendance;

use App\Models\Attendance\Attendance;
use App\Models\Employee\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DailyReport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithCustomStartCell
{
    protected $filter;

    function __construct($filter) {
        $this->filter = $filter;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array{
        return [
            'No',
            'Nama',
            'NIK',
            'Tanggal',
            'Jadwal Masuk',
            'Jadwal Keluar',
            'Aktual Masuk',
            'Aktual Keluar',
            'Durasi',
            'Keterangan'
        ];
    }

    public function collection()
    {
        //GET DATA ATTENDANCE FROM SELECTED DATE
        $sql = DB::table('attendances as t1')
            ->join('employees as t2', 't1.employee_id', 't2.id')
            ->select('t1.date', 't1.in', 't1.out', 't1.duration', 't2.id', 't2.name', 't2.emp_number', 't4.name as shiftName', 't4.start', 't4.end', 't4.tolerance')
            ->join('employee_contracts as t3',  function ($join){
                $join->on('t2.id', 't3.employee_id');
                $join->on('t3.status', DB::raw('"t"'));
            })
            ->join('attendance_shifts as t4', 't3.shift_id', 't4.id')
            ->where('t1.date', $this->filter['filterDate']);

        //SET FILTER SEARCH
        if(!empty($this->filter['filter']))
            $sql->where('t2.name', 'like', '%' . $this->filter['filter'] . '%')
                ->orWhere('t2.emp_number', 'like', '%' . $this->filter['filter'] . '%');

        $no = 0;
        $attendances = $sql->get();
        foreach ($attendances as $key => $r){
            $no++;

            $arrData[$no]['no'] = $no;
            $arrData[$no]['name'] = $r->name;
            $arrData[$no]['emp_number'] = $r->emp_number;
            $arrData[$no]['date'] = setDate($r->date);
            $arrData[$no]['shiftStart'] = substr($r->start, 0, 5);
            $arrData[$no]['shiftEnd'] = substr($r->end, 0, 5);
            $arrData[$no]['start'] = substr($r->in, 0, 5);
            $arrData[$no]['end'] = substr($r->out, 0, 5);
            $arrData[$no]['duration'] = substr($r->duration, 0, 5);

            //SET DATE AND TIME TO GET DIFF TIME
            $attStartTime = Carbon::parse($r->date. " ".$r->in);
            $shiftStartTime = Carbon::parse($r->date. " ".$r->start)->addMinute($r->tolerance);

            //GET DIFF IN MINUTES THEN APPLY IN DESCRIPTION
            $arrData[$no]['description'] = $attStartTime > $shiftStartTime ? 'Terlambat '. $attStartTime->diffInMinutes($shiftStartTime).' Menit' : '';

        }

        //CONVERT ARRAY TO COLLECTION
        $datas = collect($arrData ?? []);

        return $datas;
    }

    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        //SET TITLE / HEADER TEXT AND STYLE
        $sheet->mergeCells('A2:'.$highestColumn.'2');
        $sheet->mergeCells('A3:'.$highestColumn.'3');
        $sheet->setCellValue('A2', 'LAPORAN ABSEN HARIAN');
        $sheet->setCellValue('A3', 'TANGGAL : '.setDate($this->filter['filterDate']));
        $sheet->getStyle('A2:'.$highestColumn.'3')->applyFromArray([
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            )
        ]);

        //SET ZOOM
        $sheet->getSheetView()->setZoomScale(70);

        //SET CONTENT STYLE
        $sheet->getStyle('A2:'.$highestColumn.'5')->getFont()->setBold(true);
        $sheet->getStyle('A5:'.$highestColumn.$highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ]
            ],
        ]);
        $sheet->getStyle('D5:'.$highestColumn.$highestRow)->applyFromArray([
            'alignment' => array(
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            )
        ]);

        $sheet->setTitle('Laporan Absen Harian');
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 10,
            'J' => 20,
        ];
    }
}
