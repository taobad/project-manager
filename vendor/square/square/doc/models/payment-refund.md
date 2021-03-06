
# Payment Refund

Represents a refund of a payment made using Square. Contains information on
the original payment and the amount of money refunded.

## Structure

`PaymentRefund`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `string` |  | Unique ID for this refund, generated by Square. | getId(): string | setId(string id): void |
| `status` | `?string` | Optional | The refund's status:<br><br>- `PENDING` - awaiting approval<br>- `COMPLETED` - successfully completed<br>- `REJECTED` - the refund was rejected<br>- `FAILED` - an error occurred | getStatus(): ?string | setStatus(?string status): void |
| `locationId` | `?string` | Optional | Location ID associated with the payment this refund is attached to. | getLocationId(): ?string | setLocationId(?string locationId): void |
| `amountMoney` | [`Money`](/doc/models/money.md) |  | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): Money | setAmountMoney(Money amountMoney): void |
| `appFeeMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAppFeeMoney(): ?Money | setAppFeeMoney(?Money appFeeMoney): void |
| `processingFee` | [`?(ProcessingFee[])`](/doc/models/processing-fee.md) | Optional | Processing fees and fee adjustments assessed by Square on this refund. | getProcessingFee(): ?array | setProcessingFee(?array processingFee): void |
| `paymentId` | `?string` | Optional | The ID of the payment assocated with this refund. | getPaymentId(): ?string | setPaymentId(?string paymentId): void |
| `orderId` | `?string` | Optional | The ID of the order associated with the refund. | getOrderId(): ?string | setOrderId(?string orderId): void |
| `reason` | `?string` | Optional | The reason for the refund. | getReason(): ?string | setReason(?string reason): void |
| `createdAt` | `?string` | Optional | Timestamp of when the refund was created, in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | Timestamp of when the refund was last updated, in RFC 3339 format. | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "status": "status8",
  "location_id": "location_id4",
  "amount_money": {
    "amount": 186,
    "currency": "NGN"
  },
  "app_fee_money": {
    "amount": 106,
    "currency": "GBP"
  },
  "processing_fee": [
    {
      "effective_at": "effective_at6",
      "type": "type8",
      "amount_money": {
        "amount": 214,
        "currency": "BWP"
      }
    },
    {
      "effective_at": "effective_at7",
      "type": "type7",
      "amount_money": {
        "amount": 215,
        "currency": "BYR"
      }
    },
    {
      "effective_at": "effective_at8",
      "type": "type6",
      "amount_money": {
        "amount": 216,
        "currency": "BZD"
      }
    }
  ],
  "payment_id": "payment_id0"
}
```

