
# Retrieve Customer Group Response

Defines the fields that are included in the response body of
a request to the [RetrieveCustomerGroup](#endpoint-retrievecustomergroup) endpoint.

One of `errors` or `group` is present in a given response (never both).

## Structure

`RetrieveCustomerGroupResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](/doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `group` | [`?CustomerGroup`](/doc/models/customer-group.md) | Optional | Represents a group of customer profiles.<br><br>Customer groups can be created, modified, and have their membership defined either via<br>the Customers API or within Customer Directory in the Square Dashboard or Point of Sale. | getGroup(): ?CustomerGroup | setGroup(?CustomerGroup group): void |

## Example (as JSON)

```json
{
  "group": {
    "created_at": "2020-04-13T21:54:57.863Z",
    "id": "2TAT3CMH4Q0A9M87XJZED0WMR3",
    "name": "Loyal Customers",
    "updated_at": "2020-04-13T21:54:58Z"
  }
}
```

