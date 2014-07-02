<table id="{{ $id }}" class="{{ $class }}">
    <colgroup>
        @for ($i = 0; $i < count($columns); $i++)
        <col class="con{{ $i }}" />
        @endfor
    </colgroup>
    <thead>
    <tr>
        @foreach($columns as $i => $c)
        <th align="center" valign="middle" class="head{{ $i }}">{{ $c }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    <tr>
        @foreach($d as $dd)
        <td>{{ $dd }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
    
    <tfoot>
        <tr>
            @foreach($columns as $i => $c)
            <th align="center" valign="middle" class="head{{ $i }}">
                <input type="text" name="{{$c}}" value="" class="search_init">
            </th>
            @endforeach
        </tr>
    </tfoot>
    
</table>

<script type="text/javascript">
    jQuery(document).ready(function(){

        // dynamic table
        var oTable = jQuery('#{{ $id }}').dataTable({

            "sPaginationType": "full_numbers",
            "bProcessing": false,
            @foreach ($options as $k => $o)
                {{ json_encode($k) }}: {{ json_encode($o) }},
            @endforeach
            @foreach ($callbacks as $k => $o)
                {{ json_encode($k) }}: {{ $o }},
            @endforeach
        	
        });

    $( "#card-name" ).keyup( function () {
        if($( "#card-name" ).val().length<3)
            return;
        
         jQuery('#{{ $id }}').dataTable().fnFilter($( "#card-name" ).val(), 1);
     } );
    
    
        $("tfoot input").keyup( function () {
            jQuery('#{{ $id }}').dataTable().fnFilter( this.value, $("tfoot input").index(this));
        } );
        
    });
</script>
