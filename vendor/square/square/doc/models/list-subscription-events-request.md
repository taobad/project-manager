
# List Subscription Events Request

Defines parameters in a
[ListSubscriptionEvents](#endpoint-subscriptions-listsubscriptionevents)
endpoint request.

## Structure

`ListSubscriptionEventsRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `cursor` | `?string` | Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this to retrieve the next set of results for the original query.<br><br>For more information, see [Pagination](https://developer.squareup.com/docs/docs/working-with-apis/pagination). | getCursor(): ?string | setCursor(?string cursor): void |
| `limit` | `?int` | Optional | The upper limit on the number of subscription events to return<br>in the response.<br><br>Default: `200` | getLimit(): ?int | setLimit(?int limit): void |

## Example (as JSON)

```json
{
  "cursor": "cursor6",
  "limit": 172
}
```

