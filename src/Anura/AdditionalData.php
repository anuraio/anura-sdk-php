<?php
declare(strict_types=1);
namespace Anura;

/**
 * A class representing Additional Data for Anura Direct. 
 * Additional Data gives you the ability to pass in select points of data with your getResult() calls from AnuraDirect, 
 * essentially turning Anura into your "database for transactional data."
 */
class AdditionalData
{
    private array $data = [];

    public function __construct() {}

    /**
     * Adds a key/value pair to your additional data. 
     * If you call addElement() providing the same $key 
     * multiple times, the value at $key will be updated.
     */
    public function addElement(int $key, string $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Removes a key/value pair from your additional data.
     */
    public function removeElement(int $key)
    {
        if ($this->data[$key]) {
            unset($this->data[$key]);
        }
    }

    /**
     * Returns the number of elements set within additional data.
     */
    public function size(): int
    {
        return count($this->data);
    }

    /**
     * Returns additional data as a JSON string.
     */
    public function __toString(): string
    {
        return json_encode($this->data);
    }
}
