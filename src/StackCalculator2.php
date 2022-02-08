<?php

namespace App;

use function PHPUnit\Framework\isNull;

class StackCalculator2
{
    protected $stack;
    protected $poppedElements;
    protected $lastOperator;
  //  protected $stackOperators;
    protected $operators = [
        'pop', 'clear', 'add', 'mul', 'neg', 'inv', 'undo', 'print'
    ];
    protected $operatorsUndo = [
        'pop', 'clear', 'add', 'mul', 'neg', 'inv'
    ];


    public function __construct(Stack $stack, Stack $stackBin, Stack $stackOperators)
    {
        $this->stack = $stack;
        $this->lastOperator = null;
        $this->stackBin = $stackBin;
        $this->stackOperators = $stackOperators;
    }

    public function getCommand(string $command){
        $command = strtolower(trim($command));
        $commandValid = 0;
        if(substr($command, 0, 5) == "push " && is_numeric(substr($command, 5))){
            $this->push((float)substr($command, 5));
            $commandValid = 1;
        }elseif(in_array($command, $this->operators)){
            $this->$command();
            $commandValid = 1;
        }

        if($commandValid){
            $this->printAll();
        }else{
            echo "Input is invalid.";
        }
    }

    public function printAll()
    {
        $this->stack->print();
        echo "\n" . json_encode($this->poppedElements);
       // $this->stackBin->print();
       // $this->stackOperators->print();
    }

    protected function push(float $number)
    {
        $this->stack->push($number);
        $this->poppedElements = null;
        $this->lastOperator = 'push';
//        $this->stackBin->push(null);
//        $this->stackOperators->push('push');
    }

    protected function pop()
    {
        if($this->stack->isEmpty()){
            echo "Cannot do this operation as stack is empty.";
            return;
        }
        $this->poppedElements = $this->stack->pop();
        $this->lastOperator = 'pop';
//        $this->stackBin->push($element);
//        $this->stackOperators->push('pop');
    }

    protected function undo()
    {
        if(is_null($this->lastOperator)){
            echo "There is no operation to undo.";
            return;
        }
        $this->lastOperator = null;
        if($this->lastOperator != 'pop'){
            $this->stack->pop();
        }
        if(!is_null($this->poppedElements)){
            $this->stack->push($this->poppedElements);
            $this->poppedElements = null;
        }
    }

    protected function clear()
    {
        $this->poppedElements = $this->stack->getStackArray();
        $this->stack->clear();
        $this->lastOperator = 'clear';
    }

    protected function add()
    {
        
    }




}
