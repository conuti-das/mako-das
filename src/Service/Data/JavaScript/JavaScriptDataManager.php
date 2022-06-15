<?php

declare(strict_types=1);

namespace App\Service\Data\JavaScript;

class JavaScriptDataManager
{
    private array $jsData = [];

    public function getJSData(string $key = null): ?array
    {
        if (!is_null($key)) {
            return $this->jsData[$key] ?? null;
        }

        return $this->jsData;
    }

    public function setJSData(string $key, mixed $value): void
    {
        if (isset($this->jsData[$key])) {
            $val = $this->getJSData($key);

            // if is array add the new value to the array
            if (is_array($val)) {
                $value = (!is_array($value)) ? array($value) : $value;
                $val = array_merge($val, $value);
            } elseif (!is_array($val)) {
                $value = (!is_array($value)) ? array($value) : $value;
                $val = array($val);
                $val = array_merge($val, $value);
            }
            $this->jsData[$key] = $val;
        } else {
            $this->jsData[$key] = $value;
        }
    }

    public function toJson(string $key = null): ?string
    {
        $jsonData = $this->getJSData($key);

        return (!is_null($jsonData)) ? json_encode($jsonData, JSON_THROW_ON_ERROR) : null;
    }
}
