$('#item_count').change(function() { $('#paginator').submit(); });

/*
$('select[multiple][required]').not('table select').not('.select_nofilter').multiselect({ minWidth: 140, classes:"required" }).multiselectfilter({ classes:"required" });

$('select[multiple]').not('table select').not('.select_nofilter').multiselect({ minWidth: 140 }).multiselectfilter({ });

$('select[required]').not('select[multiple]').not('table select').not('.select_nofilter').multiselect({
    multiple: false,
    selectedList: 1,
    minWidth: 140,
    classes:"required"
}).multiselectfilter({ classes:"required" });

$('select').not('select[multiple]').not('table select').not('.select_nofilter').multiselect({
    multiple: false,
    selectedList: 1,
    minWidth: 140
}).multiselectfilter({  });

$('select.select_nofilter').not('select[multiple]').not('table select').multiselect({
    multiple: false,
    selectedList: 1,
    minWidth: 140
});
*/
decoraSelects("body");


$.fn.dataTableExt.oApi.fnAddTr = function ( oSettings, nTr, bRedraw ) {
    if ( typeof bRedraw == 'undefined' )
    {
        bRedraw = true;
    }

    var nTds = nTr.getElementsByTagName('td');
    if ( nTds.length != oSettings.aoColumns.length )
    {
        alert( 'Warning: not adding new TR - columns and TD elements must match' );
        return;
    }

    var aData = [];
    for ( var i=0 ; i<nTds.length ; i++ )
    {
        aData.push( nTds[i].innerHTML );
    }

    /* Add the data and then replace DataTable's generated TR with ours */
    var iIndex = this.oApi._fnAddData( oSettings, aData );
    nTr._DT_RowIndex = iIndex;
    oSettings.aoData[ iIndex ].nTr = nTr;

    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

    if ( bRedraw )
    {
        this.oApi._fnReDraw( oSettings );
    }
};


$.fn.dataTableExt.aTypes.jObject =  function ( sData ) {
        if ( sData instanceof jQuery )
        {
            return 'jquery-object';
        }
        return null;
};