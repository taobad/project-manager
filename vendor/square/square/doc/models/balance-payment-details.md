
# Balance Payment Details

Reflects the current status of a balance payment.

## Structure

`BalancePaymentDetails`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `accountId` | `?string` | Optional | ID for the account used to fund the payment. | getAccountId(): ?string | setAccountId(?string accountId): void |
| `status` | `?string` | Optional | The balance payment’s current state. Can be `COMPLETED` or `FAILED`. | getStatus(): ?string | setStatus(?string status): void |

## Example (as JSON)

```json
{
  "account_id": "account_id2",
  "status": "status8"
}
```

