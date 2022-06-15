<?php

declare(strict_types=1);

namespace App\Service\Data\Twig;

class TwigDataManager
{
    private array $twigData;

    public function getTwigData(string $key = null): ?array
    {
        if (!is_null($key)) {
            return $this->twigData[$key] ?? null;
        }

        return $this->twigData;
    }

    public function setTwigData(string $key, mixed $value): void
    {
        if (isset($this->twigData[$key])) {
            $val = $this->getTwigData($key);

            if (is_array($val)) {
                $value = (!is_array($value)) ? array($value) : $value;
                $val = array_merge($val, $value);
            } elseif (!is_array($val)) {
                $value = (!is_array($value)) ? array($value) : $value;
                $val = array($val);
                $val = array_merge($val, $value);
            }
            $this->twigData[$key] = $val;
        } else {
            $this->twigData[$key] = $value;
        }
    }
}
