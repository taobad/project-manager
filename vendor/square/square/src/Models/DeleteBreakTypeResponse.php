<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The response to a request to delete a `BreakType`. May contain a set
 * of `Error` objects if the request resulted in errors.
 */
class DeleteBreakTypeResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Errors.
     *
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     *
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['errors'] = $this->errors;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
