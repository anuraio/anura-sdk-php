<?php
declare(strict_types=1);
namespace Anura;

class DirectResult
{
    public string $result;
    public ?int $mobile;
    public ?array $ruleSets;
    public ?string $invalidTrafficType;

    public function __construct(string $result, ?int $mobile, ?array $ruleSets, ?string $invalidTrafficType)
    {
        $this->result = $result;
        $this->mobile = $mobile;
        $this->ruleSets = $ruleSets;
        $this->invalidTrafficType = $invalidTrafficType;
    }

    public function isSuspect(): bool
    {
        return $this->result === 'suspect';
    }

    public function isNonSuspect(): bool
    {
        return $this->result === 'non-suspect';
    }

    public function isMobile(): bool
    {
        return $this->mobile === 1;
    }
}