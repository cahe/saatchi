<?php
$callback = Input::get('callback');
$query = Input::get('q');
$queryResult =  Card::where('name', 'like', '%'.$query.'%')->get();

$result = $callback . "([";
foreach( $queryResult as $token ) {
    $result .= '"' . $token->name . ' - ' . Set::find($token->set)->name . '",';
}

$result .= "]);";

echo $result;