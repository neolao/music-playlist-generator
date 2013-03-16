<?php
/**
 * @package Playlist
 */
namespace Playlist;

use Playlist\Condition\ConditionInterface;

/**
 * Rules
 */
class Rules
{
    /**
     * Condition
     *
     * @var ConditionInterface
     */
    protected $_condition;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Initialize the rules
     *
     * @param   mixed       $conditionRaw       Raw condition
     */
    public function initialize($conditionRaw)
    {
        $this->_condition = $this->_parseCondition($conditionRaw);
    }

    /**
     * Check if the metadata matches the rules
     *
     * @param   stdClass    $metadata       File metadata
     * @return  bool                        true if the metadata matches the rules, false otherwise
     */
    public function match($metadata)
    {
        if ($this->_condition) {
            return $this->_condition->match($metadata);
        }
        return false;
    }

    /**
     * Parse the raw condition
     *
     * @param   mixed       $conditionRaw   Raw condition
     */
    protected function _parseCondition($conditionRaw)
    {
        if ($conditionRaw instanceof \stdClass) {
            $field      = $conditionRaw->field;
            $operator   = $conditionRaw->operator;
            $value      = $conditionRaw->value;

            switch ($operator) {
                case 'isEqual':
                case '=':
                    $condition = new Condition\IsEqual();
                    break;

                case 'isHigherOrEqual':
                case '>=':
                    $condition = new Condition\IsHigherOrEqual();
                    break;
            }

            $condition->setField($field);
            $condition->setValue($value);
            return $condition;
        }

        return null;
    }
}
