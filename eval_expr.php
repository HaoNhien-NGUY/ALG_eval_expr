<?php

require_once('./fn.php');

function eval_expr(string $expr)
{
    //remove first and last parentheses if there are.
    if ($expr[0] == '(' && substr($expr, -1) == ')') $expr = substr(substr($expr, 0, strlen($expr) - 1), 1);

    $expr = explodeByOperationGroup($expr);
    $lowestPrio = findLowestPriorityOperator($expr);

    if(!$lowestPrio) return $expr[0];

    [$operatorKey, $operator] = $lowestPrio;

    $left = implode(array_slice($expr, 0, $operatorKey));
    $right = implode(array_slice($expr, $operatorKey+1));

    return calculate(eval_expr($left), $operator, eval_expr($right));
}

// echo eval_expr("(((3-4*13)/32)*1+235/8*8+3)"); //236.46875
echo eval_expr("(((3-4*13)/32)*1+235/8+8+3)"); //38.84375
// echo eval_expr("((3*5-4*7)/1+1)-1/8*8+3"); // -10
// echo eval_expr("(((3-4*13)/32)*1+235/8%20*8+3)"); //76.46875

echo PHP_EOL;