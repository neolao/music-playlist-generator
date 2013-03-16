<?php
/**
 * @package Playlist\Condition
 */
namespace Playlist\Condition;

/**
 * Abstract condition
 */
abstract class ConditionAbstract implements ConditionInterface
{
    /**
     * The field to test
     *
     * @var string
     */
    protected $_field;

    /**
     * The value to test
     *
     * @var mixed
     */
    protected $_value;

    /**
     * Set the field name
     *
     * @param   string      $name       Field name
     */
    public function setField($name)
    {
        $this->_field = $name;
    }

    /**
     * Set the value
     *
     * @param   mixed       $value      Value
     */
    public function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Indicates that the condition matches the metadata
     *
     * @param   stdClass        $metadata       Media metadata
     * @return  bool                            true if the condition matches the metadata, false otherwise
     */
    public function match($metadata)
    {
        return false;
    }

    /**
     * Get the metadata value
     *
     * @return  mixed                           Metadata value
     */
    protected function _getMetadataValue($metadata)
    {
        $fieldName = $this->_field;

        if (isset($metadata->$fieldName)) {
            return $metadata->$fieldName;
        }

        return null;
    }
}
