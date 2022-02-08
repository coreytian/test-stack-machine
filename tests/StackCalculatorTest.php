<?php


class StackCalculatorTest extends \PHPUnit\Framework\TestCase
{
    protected $cal;

    public function setUp():void
    {
        $stack = new App\Stack();
        $stackBin = new App\Stack();
        $stackOperator = new App\Stack();
        $this->cal = new App\StackCalculator($stack, $stackBin, $stackOperator);
    }

    public function testPush(){
        $this->cal->run('PUSH 3');
        $this->cal->run('PUSH -1.5');
        $this->assertEquals([3, -1.5],  $this->cal->getStackArray());
    }

    public function testPop(){
        $this->cal->run('PUSH 3');
        $this->cal->run('PUSH -1.5');
        $this->cal->run('POP');
        $this->assertEquals([3], $this->cal->getStackArray());
    }

    public function testAdd(){
        $this->cal->run('PUSH 3');
        $this->cal->run('PUSH -1.5');
        $this->cal->run('PUSH 1.5');
        $this->cal->run('ADD');
        $this->assertEquals([3, 0], $this->cal->getStackArray());
    }

    public function testMul(){
        $this->cal->run('PUSH 3');
        $this->cal->run('PUSH -1.5');
        $this->cal->run('PUSH 2');
        $this->cal->run('MUL');
        $this->assertEquals([3, -3], $this->cal->getStackArray());
    }

    public function testInv(){
        $this->cal->run('PUSH 2');
        $this->cal->run('INV');
        $this->assertEquals([0.5], $this->cal->getStackArray());
    }

    public function testNeg(){
        $this->cal->run('PUSH -2');
        $this->cal->run('NEG');
        $this->assertEquals([2], $this->cal->getStackArray());
    }

    public function testClear(){
        $this->cal->run('PUSH -2');
        $this->cal->run('PUSH 3');
        $this->cal->run('CLEAR');
        $this->assertEquals([], $this->cal->getStackArray());
    }

    public function testUndo(){
        $this->cal->run('PUSH -2');
        $this->cal->run('PUSH 3');
        $this->cal->run('ADD');
        $this->cal->run('UNDO');
        $this->assertEquals([-2, 3], $this->cal->getStackArray());
        $this->cal->run('UNDO');
        $this->assertEquals([-2], $this->cal->getStackArray());
    }
}
