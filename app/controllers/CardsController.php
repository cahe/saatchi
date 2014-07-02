<?php

class CardsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('cards_dt.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
	public function getDatatable()
	{
		return Datatable::query(DB::table('cards')
		->select('cards.id', 'cards.name', 'sets.name as setname')
		->join('sets', 'cards.set_id', '=', 'sets.id'))
		->showColumns('id', 'name','setname','sell')
		->searchColumns('id','cards.name')
		->setSearchWithAlias()
		->addColumn('sell',function($model)	{
				return '<a class="popup_dodaj" name="popup_dodaj" id ="'.$model->name.'" >dodaj kartę</a>';
		})
		->orderColumns('id','cards.name')
		->make();
	}

}
