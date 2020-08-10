<?php

function explodeByOperationGroup(string $expr)
{
    $operators = ['+', '-', '/', '*', '%'];

    $block = [];
    $expr = str_split($expr);
    $openParenthese = 0;

    foreach ($expr as $value) {
        if ($value == "(") $openParenthese++;
        if ($value == ")") $openParenthese--;

        if ($openParenthese != 0 || !in_array($value, $operators)) {
            $block[] = $value;
        } else {
            $operationGroups[] = implode($block);
            $operationGroups[] = $value;
            $block = [];
        }
    }
    $operationGroups[] = implode($block);

    if (count($operationGroups) == 1 && !preg_match("/[+\-*\/%]+/", $operationGroups[0])) 
        $operationGroups[0] = trim($operationGroups[0], '()');

    return $operationGroups;
}

function findLowestPriorityOperator(array $expr)
{
    $operatorsPrio = ['+' => 1, '-' => 1, '/' => 2, '*' => 2, '%' => 2];
    $operators = array_keys($operatorsPrio);

    $lowPrio = null;
    foreach ($expr as $k => $v) {
        if (in_array($v, $operators)) {
            if ($lowPrio == null)
                $lowPrio = ['key' => $k, 'operator' => $v];
            else if ($operatorsPrio[$v] <= $operatorsPrio[$lowPrio['operator']])
                $lowPrio = ['key' => $k, 'operator' => $v];
        }
    }

    if($lowPrio == null) return false;
    return [$lowPrio['key'], $lowPrio['operator']];
}

function calculate($nb1, string $operator, $nb2)
{
    switch (trim($operator)) {
        case '+':
            return $nb1 + $nb2;
        case '-':
            return $nb1 - $nb2;
        case '*':
            return $nb1 * $nb2;
        case '/':
            return $nb1 / $nb2;
        case '%':
            return fmod($nb1, $nb2);
        default:
            return false;
    }
}