<?php

namespace App\helpers;

use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\SyntaxError;
use League\Csv\UnavailableStream;

class CsvHandler
{
    /**
     * Lê um arquivo CSV e retorna os dados como array.
     *
     * @param $filepath
     * @return array Dados do CSV.
     * @throws UnavailableStream
     * @throws Exception
     * @throws InvalidArgument
     * @throws SyntaxError
     */
    public static function readCsv($filepath, $perLine = false, $cols = []): array
    {
        $records = [];
        try {
            $csv = Reader::createFromPath($filepath, 'r');
            $csv->setHeaderOffset(0);

            if ($perLine) {
                foreach ($csv->getRecords() as $record) {
                    $records[] = [
                        'shape_id' => $record['shape_id'],
                        'latitude' => floatval($record['shape_pt_lat']),
                        'longitude' => floatval($record['shape_pt_lon']),
                    ];
                }

                return $records;
            }

            $stmt = (new Statement());
            $records = $stmt->process($csv);

        } catch (\Exception $exception) {
            Log::logException($exception);
        }

        return iterator_to_array($records, false);
    }

    public static function search(array $data, $col, $val): array
    {
        $results = [];
        foreach ($data as $row) {
            if (isset($row[$col]) && $row[$col] == $val) {
                $results[] = $row;
            }
        }

        return $results;
    }
}