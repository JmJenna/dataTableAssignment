<?php

namespace App\Controllers;

use App\Libraries\DataLoader;

class Home extends BaseController
{
    public function index()
    {
        $fileName = dirname(APPPATH, 1) . '/data/EmployeeSampleData.xlsx';        
        $dataLoader = new DataLoader();
        $excelData = $dataLoader->getData($fileName);
        $headers = $excelData[0];
        array_shift($excelData);

        return view('welcome_message', ['headers' => $headers, 'data' => $excelData]);
    }
}
