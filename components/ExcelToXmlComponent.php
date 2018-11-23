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
        trace($excelAsArray, 1);

    }

    protected function getExcelAsArray()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($this->excelFilePath);
        return $spreadsheet->getActiveSheet()->toArray();
    }
}