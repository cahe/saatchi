<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

function println( $message ) {
    print( $message . "\n" );
}

class SynchronizeCards extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cards:synchronize';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Synchronizes cards from JSON source.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        println("Loading configuration...");
        $url = Config::get("mtgjson.json_url");
        $setsFile = Config::get("mtgjson.sets_file");

        println("Fetching sets from " . $url);
        $jsonSets = file_get_contents($url . $setsFile);

        $sets = json_decode($jsonSets);
        foreach( $sets as $set ) {
            //if set not found, download and import cards
            if( Set::where('json_name', '=', $set->code)->count() == 0 ) {
                $cards = json_decode(file_get_contents($url . $set->code . ".json"));
                println($set->name . " has " . count($cards->cards) . " cards.");

                $_set = new Set;
                $_set->name = $set->name;
                $_set->json_name = $set->code;
                $_set->mcm_name = $set->name; //not always correct, must be corrected later
                $_set->save();

                foreach( $cards->cards as $card ) {
                    try {
                        $_card = new Card;
                        $_card->name = $card->name;
                        $_card->type = $card->type;
                        if( property_exists ( $card , 'text' ) ) {
                            $_card->text = $card->text;
                        }
                        $_card->rarity = $card->rarity;
                        $_card->multiverseid = $card->multiverseid;
                        $_card->set = $_set->id; //get set inserted id
                        if( property_exists ( $card , 'manaCost' ) ) {
                            $_card->mana_cost = $card->manaCost;
                        }
                        $_card->save();
                    } catch( Exception $e ) {
                        println("Cought exception " . $e->getMessage() . " on card " . $card->name);
                    }
                }
            }
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('force', null, InputOption::VALUE_OPTIONAL, 'Force refresh of all cards definitions.', null),
		);
	}
}
