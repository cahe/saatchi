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
        //helper function that first checks if property exists and then sets it
        function helper_set_nullable_property( $propertyName, $source, $destination, $destinationProperty = null ){
            if( $destinationProperty == null ) {
                $destinationProperty = $propertyName;
            }

            $sourceArray = get_object_vars($source);

            if( property_exists($source, $propertyName) ) {
                $destination[$destinationProperty] = $sourceArray[$propertyName];
            }
        }

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


                if( property_exists($cards, 'onlineOnly') ) {
                    if( $cards->onlineOnly === true ) {
                        println("Not importing, online only.");
                        continue; //import only paper sets
                    }
                }

                $_set = new Set;
                $_set->name = $set->name;
                $_set->json_name = $set->code;
                $_set->mcm_name = $set->name; //not always correct, must be corrected later
                $_set->release_date = $cards->releaseDate; //conviniently already in mysql format
                helper_set_nullable_property('gathererCode', $cards, $_set, 'gatherer_code');
                $_set->border = $cards->border;
                $_set->type = $cards->type;
                helper_set_nullable_property('block', $cards, $_set);

                $_set->save();



                foreach( $cards->cards as $card ) {
                    try {
                        $_card = new Card;
                        $_card->name = $card->name;
                        $_card->type = $card->type;
                        helper_set_nullable_property('text', $card, $_card);
                        $_card->rarity = $card->rarity;
                        helper_set_nullable_property('multiverseid', $card, $_card);
                        $_card->set_id = $_set->id; //get set inserted id
                        helper_set_nullable_property('manaCost', $card, $_card, 'mana_cost');
                        helper_set_nullable_property('cmc', $card, $_card);
                        helper_set_nullable_property('flavor', $card, $_card);
                        helper_set_nullable_property('artist', $card, $_card);
                        helper_set_nullable_property('power', $card, $_card);
                        helper_set_nullable_property('toughness', $card, $_card);
                        helper_set_nullable_property('number', $card, $_card);
                        helper_set_nullable_property('layout', $card, $_card);
                        helper_set_nullable_property('imageName', $card, $_card, 'image_name');
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
