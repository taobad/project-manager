
# Order Line Item Tax

Represents a tax that applies to one or more line item in the order.

Fixed-amount, order-scoped taxes are distributed across all non-zero line item totals.
The amount distributed to each line item is relative to the amount the item
contributes to the order subtotal.

## Structure

`OrderLineItemTax`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | Unique ID that identifies the tax only within this order. | getUid(): ?string | setUid(?string uid): void |
| `catalogObjectId` | `?string` | Optional | The catalog object id referencing [CatalogTax](#type-catalogtax). | getCatalogObjectId(): ?string | setCatalogObjectId(?string catalogObjectId): void |
| `name` | `?string` | Optional | The tax's name. | getName(): ?string | setName(?string name): void |
| `type` | [`?string (OrderLineItemTaxType)`](/doc/models/order-line-item-tax-type.md) | Optional | Indicates how the tax is applied to the associated line item or order. | getType(): ?string | setType(?string type): void |
| `percentage` | `?string` | Optional | The percentage of the tax, as a string representation of a decimal<br>number. For example, a value of `"7.25"` corresponds to a percentage of<br>7.25%. | getPercentage(): ?string | setPercentage(?string percentage): void |
| `metadata` | `?array` | Optional | Application-defined data attached to this tax. Metadata fields are intended<br>to store descriptive references or associations with an entity in another system or store brief<br>information about the object. Square does not process this field; it only stores and returns it<br>in relevant API calls. Do not use metadata to store any sensitive information (personally<br>identifiable information, card details, etc.).<br><br>Keys written by applications must be 60 characters or less and must be in the character set<br>`[a-zA-Z0-9_-]`. Entries may also include metadata generated by Square. These keys are prefixed<br>with a namespace, separated from the key with a ':' character.<br><br>Values have a max length of 255 characters.<br><br>An application may have up to 10 entries per metadata field.<br><br>Entries written by applications are private and can only be read or modified by the same<br>application.<br><br>See [Metadata](https://developer.squareup.com/docs/build-basics/metadata) for more information. | getMetadata(): ?array | setMetadata(?array metadata): void |
| `appliedMoney` | [`?Money`](/doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAppliedMoney(): ?Money | setAppliedMoney(?Money appliedMoney): void |
| `scope` | [`?string (OrderLineItemTaxScope)`](/doc/models/order-line-item-tax-scope.md) | Optional | Indicates whether this is a line item or order level tax. | getScope(): ?string | setScope(?string scope): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "catalog_object_id": "catalog_object_id6",
  "name": "name0",
  "type": "INCLUSIVE",
  "percentage": "percentage8"
}
```

