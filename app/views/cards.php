<?php
$callback = Input::get('callback');
$query = Input::get('term');
$queryResult =  Card::where('name', 'like', '%'.$query.'%')->with(
    array('set' => function($query){
        $query->select('id', 'name');
    }))->limit(100)->get(array('id','name','set_id'));

foreach( $queryResult as $resultToken ) {
    $result[] = array('value' => $resultToken->name . ' (' . $resultToken->set->name . ')', 'id' => $resultToken->id );
}

echo(json_encode($result));