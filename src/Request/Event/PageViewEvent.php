<?php

declare(strict_types=1);

namespace BluePsyduck\Ga4MeasurementProtocol\Request\Event;

use BluePsyduck\Ga4MeasurementProtocol\Attribute\Event;
use BluePsyduck\Ga4MeasurementProtocol\Attribute\Parameter;
use BluePsyduck\Ga4MeasurementProtocol\Attribute\ParameterArray;

/**
 * This is the undocumented page_view event of GA4 measurement protocol.
 *
 * @see https://stackoverflow.com/questions/71558198/send-a-pageview-event-via-measurement-protocol-to-a-ga4-property
 *
 * @author BluePsyduck <bluepsyduck@gmx.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPL v3
 */
#[Event('page_view')]
class PageViewEvent implements EventInterface
{
    /**
     * Full url of the page
     * @var string
     */
    #[Parameter('page_location')]
    public string $page_location;

    /**
     * The part part of the url
     * @var string
     */
    #[Parameter('page_title')]
    public string $page_title;
}
