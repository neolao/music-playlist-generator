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
        return true;
    }

    /**
     * Parse the raw condition
     *
     * @param   mixed       $conditionRaw   Raw condition
     */
    protected function _parseCondition($conditionRaw)
    {
        // If the raw condition is an object, then it is a simple condition
        if ($conditionRaw instanceof \stdClass) {
            $field      = $conditionRaw->field;
            $operator   = $conditionRaw->operator;
            $value      = $conditionRaw->value;

            switch ($operator) {
                case 'isEqual':
                case '=':
                    $condition = new Condition\IsEqual();
                    break;

                case 'isDifferent':
                case '!=':
                    $condition = new Condition\IsDifferent();
                    break;

                case 'isHigher':
                case '>':
                    $condition = new Condition\IsHigher();
                    break;

                case 'isHigherOrEqual':
                case '>=':
                    $condition = new Condition\IsHigherOrEqual();
                    break;

                case 'isLower':
                case '<':
                    $condition = new Condition\IsLower();
                    break;

                case 'isLowerOrEqual':
                case '<=':
                    $condition = new Condition\IsLowerOrEqual();
                    break;

                case 'contains':
                    $condition = new Condition\Contains();
                    break;
            }

            $condition->setField($field);
            $condition->setValue($value);
            return $condition;
        }

        // If the raw condition is an array, then it is a sequence condition
        if (is_array($conditionRaw)) {
            $sequence = new Condition\Sequence();

            // Populate the sequence
            // Parse each element of the raw sequence
            foreach ($conditionRaw as $element) {
                if (is_string($element)) {
                    if ($element === 'or') {
                        $sequence->addOperatorOr();
                    } else {
                        $sequence->addOperatorAnd();
                    }
                    continue;
                }

                // The current element is a condition
                $condition = $this->_parseCondition($element);
                $sequence->addCondition($condition);
            }

            return $sequence;
        }

        // Invalid condition
        throw new \Exception('Invalid condition: ' . json_encode($conditionRaw));
    }
}
