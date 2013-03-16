<?php
/**
 * @package Playlist\Condition
 */
namespace Playlist\Condition;

require_once(__DIR__ . '/ConditionInterface.php');
require_once(__DIR__ . '/ConditionAbstract.php');

use Playlist\Condition\ConditionInterface;
use Playlist\Condition\ConditionAbstract;

/**
 * Condition "isEqual"
 */
class IsEqual extends ConditionAbstract implements ConditionInterface
{
    /**
     * Indicates that the condition matches the metadata
     *
     * @param   stdClass        $metadata       Media metadata
     * @return  bool                            true if the condition matches the metadata, false otherwise
     */
    public function match($metadata)
    {
        $expected   = $this->_value;
        $value      = $this->_getMetadataValue($metadata);

        if ($value == $expected) {
            return true;
        }

        return false;
    }
}
