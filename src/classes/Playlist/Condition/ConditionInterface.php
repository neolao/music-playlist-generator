<?php
/**
 * @package Playlist\Condition
 */
namespace Playlist\Condition;

/**
 * Interface of a condition
 */
interface ConditionInterface
{
    /**
     * Set the field name
     *
     * @param   string      $name       Field name
     */
    function setField($name);

    /**
     * Set the value
     *
     * @param   mixed       $value      Value
     */
    function setValue($value);

    /**
     * Indicates that the condition matches the metadata
     *
     * @param   stdClass        $metadata       Media metadata
     * @return  bool                            true if the condition matches the metadata, false otherwise
     */
    function match($metadata);
}
