<?php
namespace app\components;

class ExcelToXmlComponent
{
    const XML_APPEND_DATA = 'xmlAppendData';

    protected $excelFilePath;

    public function __construct($excelFilePath)
    {
        $this->excelFilePath = $excelFilePath;
    }

    public function exportToXml()
    {
        $excelAsArray = $this->getExcelAsArray();
        if (\Yii::$app->session->get(self::XML_APPEND_DATA)){
            trace(111);
        }
        else{
            trace(222);
        }
    }

    protected function getExcelAsArray()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($this->filePath);
        return $spreadsheet->getActiveSheet()->toArray();
    }
}