<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Defines the response body returned from the [SearchCatalogItems](#endpoint-Catalog-
 * SearchCatalogItems) endpoint.
 */
class SearchCatalogItemsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var CatalogObject[]|null
     */
    private $items;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * @var string[]|null
     */
    private $matchedVariationIds;

    /**
     * Returns Errors.
     *
     * Any errors that occurred during the request.
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
     * Any errors that occurred during the request.
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
     * Returns Items.
     *
     * Returned items matching the specified query expressions.
     *
     * @return CatalogObject[]|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Sets Items.
     *
     * Returned items matching the specified query expressions.
     *
     * @maps items
     *
     * @param CatalogObject[]|null $items
     */
    public function setItems(?array $items): void
    {
        $this->items = $items;
    }

    /**
     * Returns Cursor.
     *
     * Pagination token used in the next request to return more of the search result.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     *
     * Pagination token used in the next request to return more of the search result.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Returns Matched Variation Ids.
     *
     * Ids of returned item variations matching the specified query expression.
     *
     * @return string[]|null
     */
    public function getMatchedVariationIds(): ?array
    {
        return $this->matchedVariationIds;
    }

    /**
     * Sets Matched Variation Ids.
     *
     * Ids of returned item variations matching the specified query expression.
     *
     * @maps matched_variation_ids
     *
     * @param string[]|null $matchedVariationIds
     */
    public function setMatchedVariationIds(?array $matchedVariationIds): void
    {
        $this->matchedVariationIds = $matchedVariationIds;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['errors']              = $this->errors;
        $json['items']               = $this->items;
        $json['cursor']              = $this->cursor;
        $json['matched_variation_ids'] = $this->matchedVariationIds;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
