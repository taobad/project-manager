<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Response object returned by GetBankAccountByV1Id.
 */
class GetBankAccountByV1IdResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var BankAccount|null
     */
    private $bankAccount;

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
     * Returns Bank Account.
     *
     * Represents a bank account. For more information about
     * linking a bank account to a Square account, see
     * [Bank Accounts API](https://developer.squareup.com/docs/docs/bank-accounts-api).
     */
    public function getBankAccount(): ?BankAccount
    {
        return $this->bankAccount;
    }

    /**
     * Sets Bank Account.
     *
     * Represents a bank account. For more information about
     * linking a bank account to a Square account, see
     * [Bank Accounts API](https://developer.squareup.com/docs/docs/bank-accounts-api).
     *
     * @maps bank_account
     */
    public function setBankAccount(?BankAccount $bankAccount): void
    {
        $this->bankAccount = $bankAccount;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['errors']      = $this->errors;
        $json['bank_account'] = $this->bankAccount;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
