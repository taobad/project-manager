
# Search Team Members Request

Represents a search request for a filtered list of `TeamMember` objects.

## Structure

`SearchTeamMembersRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `query` | [`?SearchTeamMembersQuery`](/doc/models/search-team-members-query.md) | Optional | Represents the parameters in a search for `TeamMember` objects. | getQuery(): ?SearchTeamMembersQuery | setQuery(?SearchTeamMembersQuery query): void |
| `limit` | `?int` | Optional | The maximum number of `TeamMember` objects in a page (25 by default). | getLimit(): ?int | setLimit(?int limit): void |
| `cursor` | `?string` | Optional | The opaque cursor for fetching the next page. Read about<br>[pagination](https://developer.squareup.com/docs/docs/working-with-apis/pagination) with Square APIs for more information. | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "limit": 10,
  "query": {
    "filter": {
      "location_ids": [
        "0G5P3VGACMMQZ"
      ],
      "status": "ACTIVE"
    }
  }
}
```

