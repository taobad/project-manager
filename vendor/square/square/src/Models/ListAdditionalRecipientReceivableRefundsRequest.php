<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Defines the query parameters that can be included in
 * a request to the [ListAdditionalRecipientReceivableRefunds](#endpoint-
 * listadditionalrecipientreceivablerefunds) endpoint.
 */
class ListAdditionalRecipientReceivableRefundsRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $beginTime;

    /**
     * @var string|null
     */
    private $endTime;

    /**
     * @var string|null
     */
    private $sortOrder;

    /**
     * @var string|null
     */
    private $cursor;

    /**
     * Returns Begin Time.
     *
     * The beginning of the requested reporting period, in RFC 3339 format.
     *
     * See [Date ranges](#dateranges) for details on date inclusivity/exclusivity.
     *
     * Default value: The current time minus one year.
     */
    public function getBeginTime(): ?string
    {
        return $this->beginTime;
    }

    /**
     * Sets Begin Time.
     *
     * The beginning of the requested reporting period, in RFC 3339 format.
     *
     * See [Date ranges](#dateranges) for details on date inclusivity/exclusivity.
     *
     * Default value: The current time minus one year.
     *
     * @maps begin_time
     */
    public function setBeginTime(?string $beginTime): void
    {
        $this->beginTime = $beginTime;
    }

    /**
     * Returns End Time.
     *
     * The end of the requested reporting period, in RFC 3339 format.
     *
     * See [Date ranges](#dateranges) for details on date inclusivity/exclusivity.
     *
     * Default value: The current time.
     */
    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    /**
     * Sets End Time.
     *
     * The end of the requested reporting period, in RFC 3339 format.
     *
     * See [Date ranges](#dateranges) for details on date inclusivity/exclusivity.
     *
     * Default value: The current time.
     *
     * @maps end_time
     */
    public function setEndTime(?string $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * Returns Sort Order.
     *
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     */
    public function getSortOrder(): ?string
    {
        return $this->sortOrder;
    }

    /**
     * Sets Sort Order.
     *
     * The order (e.g., chronological or alphabetical) in which results from a request are returned.
     *
     * @maps sort_order
     */
    public function setSortOrder(?string $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * Returns Cursor.
     *
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for your original query.
     *
     * See [Paginating results](#paginatingresults) for more information.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets Cursor.
     *
     * A pagination cursor returned by a previous call to this endpoint.
     * Provide this to retrieve the next set of results for your original query.
     *
     * See [Paginating results](#paginatingresults) for more information.
     *
     * @maps cursor
     */
    public function setCursor(?string $cursor): void
    {
        $this->cursor = $cursor;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['begin_time'] = $this->beginTime;
        $json['end_time']  = $this->endTime;
        $json['sort_order'] = $this->sortOrder;
        $json['cursor']    = $this->cursor;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
