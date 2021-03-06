# Apple Pay

```php
$applePayApi = $client->getApplePayApi();
```

## Class Name

`ApplePayApi`

## Register Domain

Activates a domain for use with Web Apple Pay and Square. A validation
will be performed on this domain by Apple to ensure is it properly set up as
an Apple Pay enabled domain.

This endpoint provides an easy way for platform developers to bulk activate
Web Apple Pay with Square for merchants using their platform.

To learn more about Apple Pay on Web see the Apple Pay section in the
[Square Payment Form Walkthrough](https://developer.squareup.com/docs/docs/payment-form/payment-form-walkthrough).

```php
function registerDomain(RegisterDomainRequest $body): ApiResponse
```

### Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`RegisterDomainRequest`](/doc/models/register-domain-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

### Response Type

This method returns a `Square\Utils\ApiResponse` instance. The `getResult()` method on this instance returns the response data which is of type [`RegisterDomainResponse`](/doc/models/register-domain-response.md).

### Example Usage

```php
$body_domainName = 'example.com';
$body = new Models\RegisterDomainRequest(
    $body_domainName
);

$apiResponse = $applePayApi->registerDomain($body);

if ($apiResponse->isSuccess()) {
    $registerDomainResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Get more response info...
// $statusCode = $apiResponse->getStatusCode();
// $headers = $apiResponse->getHeaders();
```

