# Stack Machine Test

A PHP command line tool of stack machine.

## Requirements

* PHP >= 7.3
* Composer


## Installation

#### Download and install

Download unzip the file on your local disk.

#### Install with Git

Clone the project and install the dependencies:

```
composer install
```

## Run

Run the following command under app root.

```
php StackMachine.php
```
Then you can enter command to run operation (Case insensitive):

```
PUSH -3.5
POP
UNDO
CLEAR
ADD
MUL
INV
NEG
PRINT
```

Enter `QUIT` to terminate the tool.

## Sample Input / Output (based on above CSV data):

### Run unit test

```
./vendor/bin/phpunit tests   
```
