
# Redeem Loyalty Reward Request

A request to redeem a loyalty reward.

## Structure

`RedeemLoyaltyRewardRequest`

## Fields

| Name | Type | Description | Getter | Setter |
|  --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | A unique string that identifies this `RedeemLoyaltyReward` request.<br>Keys can be any valid string, but must be unique for every request. | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `locationId` | `string` | The ID of the [location](#type-Location) where the reward is redeemed. | getLocationId(): string | setLocationId(string locationId): void |

## Example (as JSON)

```json
{
  "idempotency_key": "98adc7f7-6963-473b-b29c-f3c9cdd7d994",
  "location_id": "P034NEENMD09F"
}
```

