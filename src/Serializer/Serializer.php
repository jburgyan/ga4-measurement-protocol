<?php

declare(strict_types=1);

namespace BluePsyduck\Ga4MeasurementProtocol\Serializer;

use BluePsyduck\Ga4MeasurementProtocol\Request\Event\EventInterface;
use ReflectionClass;
use ReflectionException;

/**
 * The class transforming the object structure into the data structure for GA.
 *
 * @author BluePsyduck <bluepsyduck@gmx.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPL v3
 */
class Serializer implements SerializerInterface
{
    /**
     * Serialized the provided object into the string for the GA request.
     * @param object $object
     * @return string
     * @throws ReflectionException
     */
    public function serialize(object $object): string
    {
        return (string) json_encode($this->transform($object));
    }

    /**
     * Transforms the value into its data representation.
     * @param mixed $value
     * @return mixed
     * @throws ReflectionException
     */
    private function transform($value)
    {
        if ($value instanceof EventInterface) {
            return $this->transformEvent($value);
        }
        if (is_object($value)) {
            return $this->extractParameters($value);
        }
        if (is_array($value)) {
            return (object) array_map([$this, 'transform'], $value);
        }
        return $value;
    }

    private function camelCase2UnderScore($str, $separator = "_")
    {
        if (empty($str)) {
            return $str;
        }
        $str = lcfirst($str);
        $str = preg_replace("/[A-Z]/", $separator . "$0", $str);
        return strtolower($str);
    }

    /**
     * Transforms the event into its data representation.
     * @param EventInterface $event
     * @return object
     * @throws ReflectionException
     */
    private function transformEvent(EventInterface $event): object
    {
        $reflectedClass = new ReflectionClass($event);
        $eventName = str_replace('_event', '', $this->camelCase2UnderScore($reflectedClass->getShortName()));

        return (object) [
            'name' => $eventName,
            'params' => $this->extractParameters($event),
        ];
    }

    /**
     * Extracts the parameters from the object, using the attached attributes.
     * @param object $object
     * @return object
     * @throws ReflectionException
     */
    private function extractParameters(object $object): object
    {
        $parameters = [];

        $reflectedClass = new ReflectionClass($object);
        foreach ($reflectedClass->getProperties() as $reflectedProperty) {
            $value = $reflectedProperty->getValue($object);
            $attribute_name = $this->camelCase2UnderScore($reflectedProperty->getName());
            if (is_array($value)) {
                $parameters[$attribute_name] = array_map(
                    [$this, 'transform'],
                    is_array($value) ? $value : [],
                );
            } else {
                $parameters[$attribute_name] = $this->transform($value);
            }
            if (empty($parameters[$attribute_name])) {
                unset($parameters[$attribute_name]);
            }
        }

        return (object) array_filter($parameters, fn($v) => !is_null($v));
    }
}
