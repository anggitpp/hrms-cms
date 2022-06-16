<?php

namespace App\Exports\Attendance;

use App\Models\Attendance\Attendance;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DurationReport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithCustomStartCell
{
    protected $filter;

    function __construct($filter) {
        $this->filter = $filter;
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array{
        //GET TOTAL DAYS
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $this->filter['filterMonth'], $this->filter['filterYear']);

        //SET ARRAY HEADER WITH DEFAULT HEADER
        $arrHeader = array('No', 'Nama', 'NIK');

        //PUSH EACH OF DAY TO ARRAY HEADER
        for($i = 1; $i<= $totalDays; $i++)
        {
            array_push($arrHeader, $i);
        }

        return $arrHeader;
    }

    public function collection()
    {
        $employees = Employee::query()->active()->select('id','name', 'emp_number')->get();

        //GET LIST ATTENDANCE IN SELECTED MONTH AND YEAR
        $attendances = Attendance::select('employee_id', DB::raw('day(start_date) as day'), 'duration')
            ->whereMonth('date', $this->filter['filterMonth'])
            ->whereYear('date', $this->filter['filterYear'])
            ->get();

        //MAKE ARRAY FROM COLLECTION
        foreach ($attendances as $key => $value)
        {
            $absenDatas[$value->employee_id][$value->day] = $value->duration;
        }

        //SET FILTER SEARCH
        if(!empty($this->filter['filter']))
            $sql->where('name', 'like', '%' . $this->filter['filter'] . '%')
                ->orWhere('emp_number', 'like', '%' . $this->filter['filter'] . '%');

        $no = 0;
        foreach ($employees as $key => $r)
        {
            $no++;
            $arrData[$no]['no'] = $no;
            $arrData[$no]['name'] = $r->name;
            $arrData[$no]['empNumber'] = $r->emp_number;
            for ($i = 1; $i<=30; $i++)
            {
                $duration = $absenDatas[$r->id]["$i"] ?? '';
                $arrData[$no]["$i"] = substr($duration, 0, 5);
            }
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
        $sheet->setCellValue('A2', 'LAPORAN DURASI KEHADIRAN');
        $sheet->setCellValue('A3', numToMonth(intval($this->filter['filterMonth'])).' '.$this->filter['filterYear']);
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

        $sheet->setTitle('Laporan Durasi Kehadiran');
    }

    public function startCell(): string
    {
        return 'A5';
    }
    public function columnWidths(): array
    {
        //GET TOTAL DAYS
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $this->filter['filterMonth'], $this->filter['filterYear']);

        //SET ARRAY HEADER WITH DEFAULT HEADER
        $arrWidth = array(
            'A' => 5,
            'B' => 20,
            'C' => 15,
        );

        //PUSH EACH OF DAY TO ARRAY HEADER
        $no = 4;
        for($i = 1; $i<= $totalDays; $i++)
        {
            $arrWidth[numToAlpha($no)] = 10;
            $no++;
        }

        return $arrWidth;
    }
}
