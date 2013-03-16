<?php
/**
 * @package Playlist\Condition
 */
namespace Playlist\Condition;

/**
 * Sequence condition
 */
class Sequence implements ConditionInterface
{
    const OPERATOR_AND  = 'and';
    const OPERATOR_OR   = 'or';


    /**
     * The sequence list
     *
     * @var array
     */
    protected $_list;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_list = [];
    }

    /**
     * Add the operator AND in the sequence list
     */
    public function addOperatorAnd()
    {
        array_push($this->_list, self::OPERATOR_AND);
    }

    /**
     * Add the operator OR in the sequence list
     */
    public function addOperatorOr()
    {
        array_push($this->_list, self::OPERATOR_OR);
    }

    /**
     * Add a condition in the sequence list
     *
     * @param   Playlist\Condition\ConditionInterface       $condition      Condition instance
     */
    public function addCondition(ConditionInterface $condition)
    {
        array_push($this->_list, $condition);
    }

    /**
     * Indicates that the condition matches the metadata
     *
     * @param   stdClass        $metadata       Media metadata
     * @return  bool                            true if the condition matches the metadata, false otherwise
     */
    public function match($metadata)
    {
        $defaultResult = true;

        $count = count($this->_list);
        for ($index = 0; $index < $count; $index++) {
            $element = $this->_list[$index];

            // If the element is an operator, then skip it
            if (is_string($element)) {
                continue;
            }

            // Get the next operator
            $nextOperator = self::OPERATOR_AND;
            if ($index + 1 < $count && $this->_list[$index + 1] === self::OPERATOR_OR) {
                $nextOperator = self::OPERATOR_OR;
            }

            // The element is a condition
            $matchResult = $element->match($metadata);

            // If the condition matches metadata and the next operator is OR, then the sequence is true
            if ($matchResult && $nextOperator === self::OPERATOR_OR) {
                return true;
            }

            // If the condition matches metadata and the next operator is AND, then continue in the sequence
            if ($matchResult && $nextOperator === self::OPERATOR_AND) {
                $defaultResult = true;
                continue;
            }

            // If the condition does not match metadata and the next operator is AND, then the sequence is false
            if (!$matchResult && $nextOperator === self::OPERATOR_AND) {
                return false;
            }

            // If the condition does not match metadata and the next operator is OR, then continue in the sequence
            if (!$matchResult && $nextOperator === self::OPERATOR_OR) {
                $defaultResult = false;
                continue;
            }
        }

        return $defaultResult;
    }
}
