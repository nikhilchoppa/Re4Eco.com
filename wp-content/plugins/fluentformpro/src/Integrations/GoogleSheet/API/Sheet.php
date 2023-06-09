<?php

namespace FluentFormPro\Integrations\GoogleSheet\API;


class Sheet
{
    protected $api;

    protected $baseUrl = 'https://sheets.googleapis.com/v4/spreadsheets/';

    public function __construct()
    {
        $this->api = new API();
    }

    public function getHeader($sheetId, $workSheetName)
    {
        $url = $this->baseUrl.$sheetId.'/values/'.$workSheetName.'!A1:Z1';

        $headers = [
            'Authorization' => 'OAuth '.$this->api->getAccessToken()
        ];

        return $this->api->makeRequest($url, [], 'GET', $headers);
    }

    public function insertHeader($sheetId, $workSheetName, $row, $range = 'auto')
    {
        $range = $workSheetName.'!A1:'.$this->getRangeKey(count($row)).'1';

        $this->clear($sheetId, $range);
        
        $rowValues = array_values($row);

        $queryString = http_build_query([
            'valueInputOption' => 'RAW',
            'includeValuesInResponse' => 'true',
            'responseValueRenderOption' => 'UNFORMATTED_VALUE',
            'responseDateTimeRenderOption' => 'FORMATTED_STRING',
        ]);
        
        $url = $this->baseUrl.$sheetId.'/values/'.htmlspecialchars($range).'?'.$queryString;

        return $this->api->makeRequest($url, [
            'values' => [$rowValues],
            'majorDimension' => 'ROWS',
            'range' => $range
        ], 'PUT', $this->getStandardHeader());
    }

    public function insertRow($sheetId, $workSheetName, $row)
    {
        $range = $workSheetName.'!A1:'.$this->getRangeKey(count($row)).'1';

        $queryString = http_build_query([
            'valueInputOption' => 'RAW',
            'includeValuesInResponse' => 'true',
            'insertDataOption' => 'INSERT_ROWS',
            'responseValueRenderOption' => 'UNFORMATTED_VALUE',
            'responseDateTimeRenderOption' => 'SERIAL_NUMBER',
        ]);

        
        $url = $this->baseUrl.$sheetId.'/values/'.htmlspecialchars($range).':append?'.$queryString;
        
        $rowValues = array_values($row);

        $rowValues = array_map('addslashes', $rowValues);

        return $this->api->makeRequest($url, [
            'values' => [$rowValues]
        ], 'POST', $this->getStandardHeader());
    }

    private function clear($sheetId, $range)
    {
        $url = $this->baseUrl.$sheetId.'/values/'.$range.':clear';

        return $this->api->makeRequest($url, [], 'POST', $this->getStandardHeader());
    }

    private function getRangeKey($number)
    {
        $indexes = range('A', 'Z');

        if($number > 26 && $number <= 52) {
            $moreIndexes = range('A', 'Z');
            foreach ($moreIndexes as $moreIndex) {
                $indexes[] = 'A'.$moreIndex;
            }
        } else if($number > 52 && $number <= 78) {
            $moreIndexes = range('A', 'Z');
            foreach ($moreIndexes as $moreIndex) {
                $indexes[] = 'B'.$moreIndex;
            }
        } else if($number > 78 && $number <= 104) {
            $moreIndexes = range('A', 'Z');
            foreach ($moreIndexes as $moreIndex) {
                $indexes[] = 'C'.$moreIndex;
            }
        }

        $index = $number - 1;

        if(isset($indexes[$index])) {
            return $indexes[$index];
        }

        return 'CZ';
    }

    private function getStandardHeader()
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->api->getAccessToken()
        ];
    }
}
