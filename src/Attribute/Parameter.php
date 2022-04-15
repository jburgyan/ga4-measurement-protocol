<?php

declare(strict_types=1);

namespace BluePsyduck\Ga4MeasurementProtocol\Attribute;

use Attribute;

/**
 * The attribute marking an event parameter.
 *
 * @author BluePsyduck <bluepsyduck@gmx.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPL v3
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Parameter
{
    public string $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }
}
