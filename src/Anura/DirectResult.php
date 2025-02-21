<?php
declare(strict_types=1);
namespace Anura;

/**
 * Represents a visitor assessment result that is returned from the Anura Direct API.
 */
class DirectResult
{
    private string $result;
    private ?int $mobile;
    private ?array $ruleSets;
    private ?string $invalidTrafficType;

    public function __construct(string $result, ?int $mobile, ?array $ruleSets, ?string $invalidTrafficType)
    {
        $this->result = $result;
        $this->mobile = $mobile;
        $this->ruleSets = $ruleSets;
        $this->invalidTrafficType = $invalidTrafficType;
    }

    /**
     * Returns whether the visitor is deemed to be suspect.
     */
    public function isSuspect(): bool
    {
        return $this->result === 'suspect';
    }

    /**
     * Returns whether the visitor is deemed to be non-suspect.
     */
    public function isNonSuspect(): bool
    {
        return $this->result === 'non-suspect';
    }

    /**
     * Returns whether the visitor is deemed to be from a mobile device.
     */
    public function isMobile(): bool
    {
        return $this->mobile === 1;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function getMobile(): ?int
    {
        return $this->mobile;
    }

    /**
     * Getting rule sets requires "return rule sets" to be enabled. You can reach out to support to have rule sets returned. 
     * The returned value will be null on non-suspect results, and/or if you have "return rule sets" disabled. 
     */
    public function getRuleSets(): ?array
    {
        return $this->ruleSets;
    }

    /**
     * Getting invalid traffic type requires "return invalid traffic type" to be enabled. You can reach out to support to have invalid traffic type returned. 
     * The returned value will be null on non-suspect results, and/or if you have "return invalid traffic type" disabled.
     */
    public function getInvalidTrafficType(): ?string
    {
        return $this->invalidTrafficType;
    }

    public function __toString(): string
    {
        return json_encode([
            'result' => $this->result,
            'mobile' => $this->mobile,
            'ruleSets' => $this->ruleSets,
            'invalidTrafficType' => $this->invalidTrafficType
        ]);   
    }
}