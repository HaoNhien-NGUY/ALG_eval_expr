<?php

require_once('./fn.php');

function eval_expr(string $expr)
{
    $expr = explodeByOperationGroup($expr);
    if (count($expr) == 1) 
        return $expr[0];

    [$operatorKey, $operator] = findLowestPriorityOperator($expr);

    $left = implode(array_slice($expr, 0, $operatorKey));
    $right = implode(array_slice($expr, $operatorKey + 1));

    return calculate(eval_expr($left), $operator, eval_expr($right));
}