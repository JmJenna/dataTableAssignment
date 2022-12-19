<?php

namespace App\Libraries;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataLoader
{
    public function getData($fileName = '') {
        
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->getRowIterator();

        $data = [];    
        $isFirstRow = true;

        foreach($rows as $row) {
            $tmpData = [];
            $index = 0;
            foreach($row->getCellIterator() as $cell) {
                if(($isFirstRow == false && $index == 8) || ($isFirstRow == false && $index == 13)) {
                    $value = $cell->getValue();
                    if($value != null) {
                        $value = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
                        $value = date('m/d/Y', $value);
                    }} else { 
                     $value = (String) $cell->getValue();
                }
               $tmpData[] = $value;
               $index ++;
            }
            $data[] = $tmpData;
            $isFirstRow = false;
        }
        return $data;
    }
}