<?php

namespace sadi01\bidashboard\components;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;

class ExcelReport
{
    const RANGE_TYPE_DAILY = 1;
    const RANGE_TYPE_MONTHLY = 2;

    public $sheet;
    public $spreadsheet;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
    }

    public function save()
    {
        $response = [];

        $writer = new Xlsx($this->spreadsheet);
        $fileName = 'export-' . time() . '.xlsx';
        $path = Yii::getAlias('@webroot/') . $fileName;
        $writer->setPreCalculateFormulas(false)->save($path);

        if (file_exists($path)){

            // Set the headers for the response
            $headers = Yii::$app->response->getHeaders();
            $headers->set('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $headers->set('Content-Disposition: attachment; filename="'. $fileName .'"');

            Yii::$app->response->SendFile($path)->send();
            unlink($path);
            return true;
        }
        else {
            throw new NotFoundHttpException("Error while Export as Excel File");
        }
    }

    /**
     * @param $rangeDateNumber
     * The number of months of the year Or days of the month
     * @return array
     */
    public function getColumnNames($rangeDateNumber)
    {
        $columnNames = [];
        for ($i = 0; $i <= 25; $i++) {
            for ($j = ($i > 0 ? 0 : 1); $j <= 25; $j++) {
                $columnNames[] = ($i > 0 ? chr($i + 64) : '') . chr($j + 65);
                if (count($columnNames) == $rangeDateNumber) {
                    break 2;
                }
            }
        }
        return $columnNames;
    }

    public function setCellValuesOfFirstRow($model, $columnNames, $rangeDateNumber, $pdate)
    {
        $this->sheet->setCellValue('A1', 'ویجت ها');
        for ($i = 0; $i < $rangeDateNumber; $i++) {
            if ($model->range_type == self::RANGE_TYPE_DAILY){
                $this->sheet->setCellValue($columnNames[$i] . 1, $i + 1);
            }
            elseif($model->range_type == self::RANGE_TYPE_MONTHLY){
                $this->sheet->setCellValue($columnNames[$i] . 1, $pdate->jdate_words(['mm' => $i + 1], ' '));
            }
        }
    }

    public function setCellValues($excel, $widgets, $columnNames, $rangeDateNumber, $isBox = false) {
        foreach ($widgets as $index => $widget) {
            $title = $isBox ? $widget->title . ' | ' . $widget->widget->description : $widget->widget->title;
            $excel->sheet->setCellValue('A' . $index + 2, $title);
            $results = $isBox ? $widget->results['chartData'] : $widget->results['final_result'];
            foreach ($results as $i => $data){
                $excel->sheet->setCellValue($columnNames[$i] . $index + 2, $results[$i]);
                if ($rangeDateNumber == $i + 1) {
                    break;
                }
            }
        }
    }
}
