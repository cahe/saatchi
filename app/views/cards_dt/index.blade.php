<!doctype html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
    
   	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>

    </head>
    
    <body>
    
    
        <script>
        $(function() {
            function log( message ) {
                $( "<div>" ).text( message ).prependTo( "#log" );
                $( "#log" ).scrollTop( 0 );
            }

            $( "#card-name" ).autocomplete({
                source: "cards",
                minLength: 3,
                select: function( event, ui ) {
                    log( ui.item ?
                        "Selected: " + ui.item.id :
                        "Nothing selected, input was " + this.value);

                    $("#card-name").val("");
                    return false;
                },
                open: function() {
                    $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                    $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            });
        });
    </script>
    
    <div class="ui-widget">
    <label for="card-name">Card name: </label>
    <input id="card-name">
</div>

<div class="ui-widget" style="margin-top:2em; font-family:Arial">
    Result:
    <div id="log" style="height: 100px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>
    


{{ $table = Datatable::table()
    ->addColumn('id','name','set','dodaj do biblioteki')       // these are the column headings to be shown
    ->setUrl(route('api.cards'))   // this is the route where data will be retrieved
	->setCallbacks('fnDrawCallback', "function (  ) {
	 $('.popup_dodaj').click(function(){
               alert('dodam kartę: '+$(this).attr('id'));
           });
		}")
    ->render('cards_dt.template');
 }}
    

    </body>
</html>