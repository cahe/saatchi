<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Autocomplete Test</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <style>
        .ui-autocomplete-loading {
            background: white url("http://www.gpc2life.com/images/loading16.gif") right center no-repeat;
        }
        #city { width: 25em; }
    </style>
    <script>
        $(function() {
            function log( message ) {
                $( "<div>" ).text( message ).prependTo( "#log" );
                $( "#log" ).scrollTop( 0 );
            }

            $( "#card-name" ).autocomplete({
                source: "/cards",
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
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                return $( "<li>" )
                    .append( '<div style="margin-left: 10px; float: right"><img src="'+ item.set_image +'" style="height: 16px"/></div> ' + item.value)
                    .appendTo( ul );
            };
        });
    </script>
</head>
<body>

<div class="ui-widget">
    <label for="card-name">Card name: </label>
    <input id="card-name">
</div>

<div class="ui-widget" style="margin-top:2em; font-family:Arial">
    Result:
    <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>


</body>
</html>