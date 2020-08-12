<?php

require_once('./eval_expr.php');

// echo eval_expr("(((3-4*13)/32)*1+235/8*8+3)"); //236.46875
// echo eval_expr("(((3-4*13)/32)*1+235/8%20*8+3)"); //76.46875
// echo eval_expr("((3*5-4*7)/1+1)-1/8*8+3"); // -10
// echo eval_expr("((((3+4)+(2+1))))"); //10
// echo eval_expr("(((((100))))-(((3+2)))*2)/(3-2)"); //90
echo eval_expr("3*(-3-(-2))");

echo PHP_EOL;