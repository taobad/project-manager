<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Represents a unit of measurement to use with a quantity, such as ounces
 * or inches. Exactly one of the following fields are required: `custom_unit`,
 * `area_unit`, `length_unit`, `volume_unit`, and `weight_unit`.
 */
class MeasurementUnit implements \JsonSerializable
{
    /**
     * @var MeasurementUnitCustom|null
     */
    private $customUnit;

    /**
     * @var string|null
     */
    private $areaUnit;

    /**
     * @var string|null
     */
    private $lengthUnit;

    /**
     * @var string|null
     */
    private $volumeUnit;

    /**
     * @var string|null
     */
    private $weightUnit;

    /**
     * @var string|null
     */
    private $genericUnit;

    /**
     * @var string|null
     */
    private $timeUnit;

    /**
     * @var string|null
     */
    private $type;

    /**
     * Returns Custom Unit.
     *
     * The information needed to define a custom unit, provided by the seller.
     */
    public function getCustomUnit(): ?MeasurementUnitCustom
    {
        return $this->customUnit;
    }

    /**
     * Sets Custom Unit.
     *
     * The information needed to define a custom unit, provided by the seller.
     *
     * @maps custom_unit
     */
    public function setCustomUnit(?MeasurementUnitCustom $customUnit): void
    {
        $this->customUnit = $customUnit;
    }

    /**
     * Returns Area Unit.
     *
     * Unit of area used to measure a quantity.
     */
    public function getAreaUnit(): ?string
    {
        return $this->areaUnit;
    }

    /**
     * Sets Area Unit.
     *
     * Unit of area used to measure a quantity.
     *
     * @maps area_unit
     */
    public function setAreaUnit(?string $areaUnit): void
    {
        $this->areaUnit = $areaUnit;
    }

    /**
     * Returns Length Unit.
     *
     * The unit of length used to measure a quantity.
     */
    public function getLengthUnit(): ?string
    {
        return $this->lengthUnit;
    }

    /**
     * Sets Length Unit.
     *
     * The unit of length used to measure a quantity.
     *
     * @maps length_unit
     */
    public function setLengthUnit(?string $lengthUnit): void
    {
        $this->lengthUnit = $lengthUnit;
    }

    /**
     * Returns Volume Unit.
     *
     * The unit of volume used to measure a quantity.
     */
    public function getVolumeUnit(): ?string
    {
        return $this->volumeUnit;
    }

    /**
     * Sets Volume Unit.
     *
     * The unit of volume used to measure a quantity.
     *
     * @maps volume_unit
     */
    public function setVolumeUnit(?string $volumeUnit): void
    {
        $this->volumeUnit = $volumeUnit;
    }

    /**
     * Returns Weight Unit.
     *
     * Unit of weight used to measure a quantity.
     */
    public function getWeightUnit(): ?string
    {
        return $this->weightUnit;
    }

    /**
     * Sets Weight Unit.
     *
     * Unit of weight used to measure a quantity.
     *
     * @maps weight_unit
     */
    public function setWeightUnit(?string $weightUnit): void
    {
        $this->weightUnit = $weightUnit;
    }

    /**
     * Returns Generic Unit.
     */
    public function getGenericUnit(): ?string
    {
        return $this->genericUnit;
    }

    /**
     * Sets Generic Unit.
     *
     * @maps generic_unit
     */
    public function setGenericUnit(?string $genericUnit): void
    {
        $this->genericUnit = $genericUnit;
    }

    /**
     * Returns Time Unit.
     *
     * Unit of time used to measure a quantity (a duration).
     */
    public function getTimeUnit(): ?string
    {
        return $this->timeUnit;
    }

    /**
     * Sets Time Unit.
     *
     * Unit of time used to measure a quantity (a duration).
     *
     * @maps time_unit
     */
    public function setTimeUnit(?string $timeUnit): void
    {
        $this->timeUnit = $timeUnit;
    }

    /**
     * Returns Type.
     *
     * Describes the type of this unit and indicates which field contains the unit information. This is an
     * ???open??? enum.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     *
     * Describes the type of this unit and indicates which field contains the unit information. This is an
     * ???open??? enum.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['custom_unit'] = $this->customUnit;
        $json['area_unit']   = $this->areaUnit;
        $json['length_unit'] = $this->lengthUnit;
        $json['volume_unit'] = $this->volumeUnit;
        $json['weight_unit'] = $this->weightUnit;
        $json['generic_unit'] = $this->genericUnit;
        $json['time_unit']   = $this->timeUnit;
        $json['type']        = $this->type;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
