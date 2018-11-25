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
        return (new XmlComponent())->export($excelAsArray);
    }

    protected function getExcelAsArray()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($this->excelFilePath);
        return $spreadsheet->getActiveSheet()->toArray();
    }
}