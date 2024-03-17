<?php

namespace sadi01\bidashboard\components;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;

class ExcelReport
{
    public $sheet;
    public $spreadsheet;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
    }


    public function save() : Array
    {
        $response = [];

        $writer = new Xlsx($this->spreadsheet);
        $fileName = 'export-' . time() . '.xlsx';
        $path = Yii::getAlias('@backend') . '/web/uploads/' . $fileName;
        $writer->setPreCalculateFormulas(false)->save($path);
        $response['status'] = file_exists($path);
        $response['message'] = Yii::t("biDashboard", $response['status'] ? 'The Operation Was Successful' : 'The Operation Failed');

        return $response;
    }

}