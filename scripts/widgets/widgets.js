jQuery(document).ready( function($) {

    // jQuery
    var $grid = $('.grid').packery({
        itemSelector: '.portlet',
        // columnWidth helps with drop positioning
        columnWidth: 5
    });
    $grid.find('.portlet').each( function( i, gridItem ) {
        var draggie = new Draggabilly( gridItem );
        // bind drag events to Packery
        $grid.packery( 'bindDraggabillyEvents', draggie );
    });
    function orderItems() {
        var itemElems = $grid.packery('getItemElements');
        $( itemElems ).each( function( i, itemElem ) {
            console.log(i + 1, itemElem.id);
        });

    }

    $grid.on( 'layoutComplete', orderItems );
    $grid.on( 'dragItemPositioned', orderItems );

    $( ".portlet-toggle" ).on( "click", function() {
        var icon = $( this );
        icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick closed" );
        icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
    });

    $.tablesorter.addWidget({
        // give the widget a id
        id: "repeatHeaders",
        // format is called when the on init and when a sorting has finished
        format: function(table) {
            // cache and collect all TH headers
            if(!this.headers) {
                var h = this.headers = [];
                $("thead th",table).each(function() {
                    h.push(
                        $(this).text()
                    );

                });

            }

            var repeat_header = $(document.createElement('tr'));
            repeat_header.addClass("repeated-header");
            for(var j=0; j < this.headers.length; j++) {
                console.log(this.headers[j]);
                repeat_header.append("<th>" + this.headers[j] + "</th>");
            }

            // remove appended headers by classname.
            $("tr.repeated-header",table).remove();

            // loop all tr elements and insert a copy of the "headers"
            for(var i=0; i < table.tBodies[0].rows.length; i++) {

                // insert a copy of the table head every 10th row
                if((i / 3) === 1) {
                    console.log(repeat_header);
                    $("tbody tr:eq(" + i + ")").before(
                        repeat_header
                    );
                }
            }
        }
    });

    $("#accountsTable").tablesorter({sortList: [[0,0]], widgets: ['zebra', 'repeatHeaders']});

    $("#contactsTable").tablesorter({
        // sort on the first column and third column, order asc
        sortList: [[4,0],[1,0]]
    });
} );

(function(document) {
    'use strict';

    var LightTableFilter = (function(Arr) {

        var _input;

        function _onInputEvent(e) {
            _input = e.target;
            var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
            Arr.forEach.call(tables, function(table) {
                Arr.forEach.call(table.tBodies, function(tbody) {
                    Arr.forEach.call(tbody.rows, _filter);
                });
            });
        }

        function _filter(row) {
            var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
            row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
        }

        return {
            init: function() {
                var inputs = document.getElementsByClassName('light-table-filter');
                Arr.forEach.call(inputs, function(input) {
                    input.oninput = _onInputEvent;
                });
            }
        };
    })(Array.prototype);

    document.addEventListener('readystatechange', function() {
        if (document.readyState === 'complete') {
            LightTableFilter.init();
        }
    });

})(document);