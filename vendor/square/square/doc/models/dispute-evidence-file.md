
# Dispute Evidence File

A file to be uploaded as dispute evidence.

## Structure

`DisputeEvidenceFile`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filename` | `?string` | Optional | The file name including the file extension. For example: "receipt.tiff". | getFilename(): ?string | setFilename(?string filename): void |
| `filetype` | `?string` | Optional | Dispute evidence files must one of application/pdf, image/heic, image/heif, image/jpeg, image/png, image/tiff formats. | getFiletype(): ?string | setFiletype(?string filetype): void |

## Example (as JSON)

```json
{
  "filename": "filename2",
  "filetype": "filetype2"
}
```

