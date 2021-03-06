<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Filtering criteria to use for a SearchOrders request. Multiple filters
 * will be ANDed together.
 */
class SearchOrdersFilter implements \JsonSerializable
{
    /**
     * @var SearchOrdersStateFilter|null
     */
    private $stateFilter;

    /**
     * @var SearchOrdersDateTimeFilter|null
     */
    private $dateTimeFilter;

    /**
     * @var SearchOrdersFulfillmentFilter|null
     */
    private $fulfillmentFilter;

    /**
     * @var SearchOrdersSourceFilter|null
     */
    private $sourceFilter;

    /**
     * @var SearchOrdersCustomerFilter|null
     */
    private $customerFilter;

    /**
     * Returns State Filter.
     *
     * Filter by current Order `state`.
     */
    public function getStateFilter(): ?SearchOrdersStateFilter
    {
        return $this->stateFilter;
    }

    /**
     * Sets State Filter.
     *
     * Filter by current Order `state`.
     *
     * @maps state_filter
     */
    public function setStateFilter(?SearchOrdersStateFilter $stateFilter): void
    {
        $this->stateFilter = $stateFilter;
    }

    /**
     * Returns Date Time Filter.
     *
     * Filter for `Order` objects based on whether their `CREATED_AT`,
     * `CLOSED_AT` or `UPDATED_AT` timestamps fall within a specified time range.
     * You can specify the time range and which timestamp to filter for. You can filter
     * for only one time range at a time.
     *
     * For each time range, the start time and end time are inclusive. If the end time
     * is absent, it defaults to the time of the first request for the cursor.
     *
     * __Important:__ If you use the DateTimeFilter in a SearchOrders query,
     * you must also set the `sort_field` in [OrdersSort](#type-searchorderordersort)
     * to the same field you filter for. For example, if you set the `CLOSED_AT` field
     * in DateTimeFilter, you must also set the `sort_field` in SearchOrdersSort to
     * `CLOSED_AT`. Otherwise, SearchOrders will throw an error.
     * [Learn more about filtering orders by time range](https://developer.squareup.com/docs/orders-
     * api/manage-orders#important-note-on-filtering-orders-by-time-range).
     */
    public function getDateTimeFilter(): ?SearchOrdersDateTimeFilter
    {
        return $this->dateTimeFilter;
    }

    /**
     * Sets Date Time Filter.
     *
     * Filter for `Order` objects based on whether their `CREATED_AT`,
     * `CLOSED_AT` or `UPDATED_AT` timestamps fall within a specified time range.
     * You can specify the time range and which timestamp to filter for. You can filter
     * for only one time range at a time.
     *
     * For each time range, the start time and end time are inclusive. If the end time
     * is absent, it defaults to the time of the first request for the cursor.
     *
     * __Important:__ If you use the DateTimeFilter in a SearchOrders query,
     * you must also set the `sort_field` in [OrdersSort](#type-searchorderordersort)
     * to the same field you filter for. For example, if you set the `CLOSED_AT` field
     * in DateTimeFilter, you must also set the `sort_field` in SearchOrdersSort to
     * `CLOSED_AT`. Otherwise, SearchOrders will throw an error.
     * [Learn more about filtering orders by time range](https://developer.squareup.com/docs/orders-
     * api/manage-orders#important-note-on-filtering-orders-by-time-range).
     *
     * @maps date_time_filter
     */
    public function setDateTimeFilter(?SearchOrdersDateTimeFilter $dateTimeFilter): void
    {
        $this->dateTimeFilter = $dateTimeFilter;
    }

    /**
     * Returns Fulfillment Filter.
     *
     * Filter based on [Order Fulfillment](#type-orderfulfillment) information.
     */
    public function getFulfillmentFilter(): ?SearchOrdersFulfillmentFilter
    {
        return $this->fulfillmentFilter;
    }

    /**
     * Sets Fulfillment Filter.
     *
     * Filter based on [Order Fulfillment](#type-orderfulfillment) information.
     *
     * @maps fulfillment_filter
     */
    public function setFulfillmentFilter(?SearchOrdersFulfillmentFilter $fulfillmentFilter): void
    {
        $this->fulfillmentFilter = $fulfillmentFilter;
    }

    /**
     * Returns Source Filter.
     *
     * Filter based on order `source` information.
     */
    public function getSourceFilter(): ?SearchOrdersSourceFilter
    {
        return $this->sourceFilter;
    }

    /**
     * Sets Source Filter.
     *
     * Filter based on order `source` information.
     *
     * @maps source_filter
     */
    public function setSourceFilter(?SearchOrdersSourceFilter $sourceFilter): void
    {
        $this->sourceFilter = $sourceFilter;
    }

    /**
     * Returns Customer Filter.
     *
     * Filter based on Order `customer_id` and any Tender `customer_id`
     * associated with the Order. Does not filter based on the
     * [FulfillmentRecipient](#type-orderfulfillmentrecipient) `customer_id`.
     */
    public function getCustomerFilter(): ?SearchOrdersCustomerFilter
    {
        return $this->customerFilter;
    }

    /**
     * Sets Customer Filter.
     *
     * Filter based on Order `customer_id` and any Tender `customer_id`
     * associated with the Order. Does not filter based on the
     * [FulfillmentRecipient](#type-orderfulfillmentrecipient) `customer_id`.
     *
     * @maps customer_filter
     */
    public function setCustomerFilter(?SearchOrdersCustomerFilter $customerFilter): void
    {
        $this->customerFilter = $customerFilter;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['state_filter']      = $this->stateFilter;
        $json['date_time_filter']  = $this->dateTimeFilter;
        $json['fulfillment_filter'] = $this->fulfillmentFilter;
        $json['source_filter']     = $this->sourceFilter;
        $json['customer_filter']   = $this->customerFilter;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
