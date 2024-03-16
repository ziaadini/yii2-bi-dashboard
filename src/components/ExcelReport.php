<?php

namespace sadi01\bidashboard\components;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;

class ExcelReport
{
    public $queryParams;


    public function save()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(json_decode($this->queryParams, true));

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Fetch data from DataProvider
        $data = $dataProvider->query->asArray()->all();
        $count = $dataProvider->query->count() + 1;

        $sheet->setCellValue('A1', 'نام');
        $sheet->setCellValue('B1', 'نام خانوادگی');
        $sheet->setCellValue('C1', 'شماره موبایل');
        $row = 2;

        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['user']['first_name']);
            $sheet->setCellValue('B' . $row, $item['user']['last_name']);
            $sheet->setCellValue('C' . $row, $item['user']['username']);
            $row++;
        }
        // Save the spreadsheet to a file
        $writer = new Xlsx($spreadsheet);
        $filename = Yii::getAlias('@backend') . '/web/upload/Excel/' . 'report.xlsx';
        $writer->setPreCalculateFormulas(false)->save($filename);
    }

}