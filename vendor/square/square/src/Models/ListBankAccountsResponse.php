<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Response object returned by ListBankAccounts.
 */
class ListBankAccountsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var BankAccount[]|null
     */
    private $bankAccounts;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * Returns Errors.
     *
     * Information on errors encountered during the request.
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
     * Information on errors encountered during the request.
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
     * Returns Bank Accounts.
     *
     * List of BankAccounts associated with this account.
     *
     * @return BankAccount[]|null
     */
    public function getBankAccounts(): ?array
    {
        return $this->bankAccounts;
    }

    /**
     * Sets Bank Accounts.
     *
     * List of BankAccounts associated with this account.
     *
     * @maps bank_accounts
     *
     * @param BankAccount[]|null $bankAccounts
     */
    public function setBankAccounts(?array $bankAccounts): void
    {
        $this->bankAccounts = $bankAccounts;
    }

    /**
     * Returns Cursor.
     *
     * When a response is truncated, it includes a cursor that you can
     * use in a subsequent request to fetch next set of bank accounts.
     * If empty, this is the final response.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/docs/working-with-
     * apis/pagination).
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     *
     * When a response is truncated, it includes a cursor that you can
     * use in a subsequent request to fetch next set of bank accounts.
     * If empty, this is the final response.
     *
     * For more information, see [Pagination](https://developer.squareup.com/docs/docs/working-with-
     * apis/pagination).
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['errors']       = $this->errors;
        $json['bank_accounts'] = $this->bankAccounts;
        $json['cursor']       = $this->cursor;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
