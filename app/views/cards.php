<?php
$query = Input::get('term');
$queryResult =  Card::where('name', 'like', '%'.$query.'%')->with(
    array('set' => function($query){
            $query->select('id', 'name', 'json_name as code');
        }))->limit(100)->get(array('id','name','set_id', 'rarity'));

$result = array();
foreach( $queryResult as $resultToken ) {
    $result[] = array('value' => $resultToken->name, 'id' => $resultToken->id, 'set_image' => 'http://mtgimage.com/symbol/set/' . $resultToken->set->code . '/'. substr($resultToken->rarity, 0, 1) .'/32.png' );
}

echo(json_encode($result));