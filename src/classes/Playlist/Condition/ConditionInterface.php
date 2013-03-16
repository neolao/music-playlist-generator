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
     * Indicates that the condition matches the metadata
     *
     * @param   stdClass        $metadata       Media metadata
     * @return  bool                            true if the condition matches the metadata, false otherwise
     */
    function match($metadata);
}
