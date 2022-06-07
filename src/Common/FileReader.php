<?php

declare(strict_types=1);

namespace App\Common;

use App\Exception\File\FileReadException;
use Exception;

class FileReader
{
    public function getContent(string $filePath): string
    {
        try {
            return file_get_contents($filePath);
        } catch (Exception $exception) {
            throw new FileReadException("Can not read file, in FileReader::getContent function. ${$filePath}");
        }
    }

    public function csvToArray($csvFile, $length = 1000, $separator = ','): array
    {
        $lines = [];

        try {
            $fileToRead = fopen($csvFile, 'r');
            $index = fgetcsv($fileToRead, $length, $separator);

            while (!feof($fileToRead)) {
                $listParams = fgetcsv($fileToRead, $length, $separator);
                if ($listParams) {
                    $lines[] = array_combine($index, $listParams);
                }
            }
            fclose($fileToRead);
        } catch (Exception $exception) {
            throw new FileReadException("Invalid csv provided in FileReader::csvToArray function. ${$csvFile}");
        }

        return $lines;
    }
}
