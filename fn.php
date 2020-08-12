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

    if (count($operationGroups) == 1) {
        $expr = $operationGroups[0];
        $hasOperator = preg_match("/[+\-*\/%]+/", $expr);
        if (!$hasOperator) {
            return [trim($expr, '()')];
        } else if ($expr[0] == '(' && substr($expr, -1) == ')') {
            $expr = substr(substr($expr, 0, strlen($expr) - 1), 1);
            return explodeByOperationGroup($expr);
        }
    }

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

    if ($lowPrio == null) return false;
    return [$lowPrio['key'], $lowPrio['operator']];
}

function calculate($nb1, string $operator, $nb2)
{
    if(!is_numeric($nb1) || !is_numeric($nb2))
        exit("Malformed expression." . PHP_EOL);

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
