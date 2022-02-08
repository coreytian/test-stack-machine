<?php
namespace App;

class Stack
{
    protected $stack = [];

    /**
     * Push element into the stack. If the element is an array, merge it into the stack array.
     * @param $element
     * @return void
     */
    public function push($element)
    {
        if(is_array($element)){
            $this->stack = array_merge($this->stack, $element);
        }else{
            $this->pushAsOneElement($element);
        }
    }

    /**
     * @param $element
     * @return void
     */
    public function pushAsOneElement($element)
    {
        $this->stack[] = $element;
    }

    /**
     * @return mixed|null
     */
    public function pop()
    {
        return array_pop($this->stack);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->stack);
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return count($this->stack);
    }

    /**
     * @return array
     */
    public function getStackArray(): array
    {
        return $this->stack;
    }

    /**
     * @return void
     */
    public function clear()
    {
        $this->stack = [];
    }

    /**
     * @return void
     */
    public function print()
    {
        echo json_encode($this->stack)."\n";
    }
}
