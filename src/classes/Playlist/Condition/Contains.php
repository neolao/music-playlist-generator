<?php
/**
 * @package Playlist\Condition
 */
namespace Playlist\Condition;

/**
 * Condition "contains"
 */
class Contains extends ConditionAbstract implements ConditionInterface
{
    /**
     * Indicates that the condition matches the metadata
     *
     * @param   stdClass        $metadata       Media metadata
     * @return  bool                            true if the condition matches the metadata, false otherwise
     */
    public function match($metadata)
    {
        $search     = $this->_value;
        $value      = $this->_getMetadataValue($metadata);

        if (strpos($value, $search) !== false) {
            return true;
        }

        return false;
    }
}
