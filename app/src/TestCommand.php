<?php
namespace Lendable\Interview\Interpolation;

require 'Services/FeeCalculator.php';
require 'Services/InterpolationInterface.php';
require 'Services/RoundInterface.php';
require 'Services/Calculator.php';
require 'Services/Interpolation.php';
require 'Services/Round.php';
require 'Model/LoanApplication.php';
require 'Model/Term.php';
require 'Model/Term12.php';
require 'Model/Term24.php';
use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Model\Term12;
use Lendable\Interview\Interpolation\Model\Term24;
use Lendable\Interview\Interpolation\Services\Calculator;
use Lendable\Interview\Interpolation\Services\Interpolation;
use Lendable\Interview\Interpolation\Services\Round;

$calculator = new Calculator(new Interpolation(), new Round());
if (!$argv[1]) {
    echo "messing ammount !!!!" . "\n";
    return;
}
// $term = new Term();
// $term->addBreakpoint(2200, 100);
// $term->addBreakpoint(3000, 170);
//php src/TestCommand.php 2000
$application = new LoanApplication(Term12::make(), $argv[1]);
$fee = $calculator->calculate($application);
echo "term 12 fee is : " . $fee . "\n";
$application = new LoanApplication(Term24::make(), $argv[1]);
$fee = $calculator->calculate($application);
echo "term 24 fee is: " . $fee . "\n";
