<?php

namespace App;


class StackCalculator
{
    /**
     * The main stack.
     * @var Stack
     */
    protected $stack;

    /**
     * The stack that stores all the popped out elements, used for the UNDO.
     * @var Stack
     */
    protected $stackBin;

    /**
     * The stack that stores the completed operators, used for the UNDO.
     * @var Stack
     */
    protected $stackOperators;

    protected $operators = [
        'pop', 'clear', 'add', 'mul', 'neg', 'inv', 'undo', 'print'
    ];
    protected $operatorsWithParam = [
        'push'
    ];

    /**
     * @param Stack $stack
     * @param Stack $stackBin
     * @param Stack $stackOperators
     */
    public function __construct(Stack $stack, Stack $stackBin, Stack $stackOperators)
    {
        $this->stack = $stack;
        $this->stackBin = $stackBin;
        $this->stackOperators = $stackOperators;
    }

    /**
     * Execute the command line from input
     * @param string $command
     * @return void
     */
    public function run(string $command){
        $command = strtolower(trim($command));
        $param = '';
        $hasParam = 0;

        if (strpos($command, ' ') !== false) {
            list($operator, $param) = explode(" ", $command, 2);
            if(in_array($operator, $this->operatorsWithParam)){
                $hasParam = 1;
            }
        }else{
            $operator = $command;
        }

        if($hasParam){
            $this->$operator($param);
        }elseif(in_array($operator, $this->operators)){
            $this->$operator();
        }else{
            echo "Input is invalid.\n";
        }
    }

    /**
     * Perform the operation that needs one element from stack. E.g. INV, NEG
     * @param string $operator
     * @return void
     */
    protected function operatorOneElements(string $operator)
    {
        if($this->stack->isEmpty()){
            echo "No enough element in the stack for this operation.\n";
            return;
        }

        $element = $this->stack->pop();

        switch ($operator){
            case 'inv':
                $result = 1 / $element;
                break;
            case 'neg':
                $result = -1 * $element;
                break;
            default:
                $result = null;
        }

        $this->stack->push($result);
        $this->stackBin->push($element);
        $this->stackOperators->push($operator);
    }

    /**
     * Perform the operation that needs two element from stack. e.g. ADD, MUL
     * @param string $operator
     * @return void
     */
    protected function operatorTwoElements(string $operator)
    {
        if($this->stack->getSize() < 2){
            echo "No enough element in the stack for this operation.\n";
            return;
        }
        $element1 = $this->stack->pop();
        $element2 = $this->stack->pop();
        switch ($operator){
            case 'add':
                $result = $element1 + $element2;
                break;
            case 'mul':
                $result = $element1 * $element2;
                break;
            default:
                $result = null;
        }

        $this->stack->push($result);
        $this->stackBin->pushAsOneElement([$element2, $element1]);
        $this->stackOperators->push($operator);
    }

    /**
     * @param $element
     * @return void
     */
    protected function push($element)
    {
        if(!is_numeric($element)){
            echo "The value must be a number for PUSH \n";
            return;
        }
        $this->stack->push((float)$element);
        $this->stackBin->push(null);
        $this->stackOperators->push('push');
    }

    /**
     * @return void
     */
    protected function pop()
    {
        if($this->stack->isEmpty()){
            echo "Cannot do this operation as stack is empty.\n";
            return;
        }
        $element = $this->stack->pop();
        $this->stackBin->push($element);
        $this->stackOperators->push('pop');
    }

    /**
     * @return void
     */
    protected function inv()
    {
        $this->operatorOneElements('inv');
    }

    /**
     * @return void
     */
    protected function neg()
    {
        $this->operatorOneElements('neg');
    }

    /**
     * @return void
     */
    protected function add()
    {
        $this->operatorTwoElements('add');
    }

    /**
     * @return void
     */
    protected function mul()
    {
        $this->operatorTwoElements('mul');
    }

    /**
     * @return void
     */
    protected function clear()
    {
        $stackArray = $this->stack->getStackArray();
        $this->stack->clear();
        $this->stackBin->pushAsOneElement($stackArray);
        $this->stackOperators->push('clear');
    }

    /**
     * @return void
     */
    protected function undo()
    {
        if($this->stackOperators->isEmpty()){
            echo "There is no operation to undo.\n";
            return;
        }

        $lastOperator = $this->stackOperators->pop();
        $lastElement = $this->stackBin->pop();

        if($lastOperator != 'pop'){
            $this->stack->pop();
        }

        if(!is_null($lastElement)){
            $this->stack->push($lastElement);
        }
    }

    /**
     * @return void
     */
    public function print()
    {
        $this->stack->print();
    }

    /**
     * @return void
     */
    public function printAll()
    {
        $this->stack->print();
        $this->stackBin->print();
        $this->stackOperators->print();
    }

    /**
     * @return array
     */
    public function getStackArray(): array
    {
        return $this->stack->getStackArray();
    }
}
