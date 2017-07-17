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

    function save_main_options_ajax() {
        var form = $('#nrw-dashboard-options');
        $.ajax( {
            type: "POST",
            url: "options.php",
            data: form.serialize(),
            success: function( response ) {
                console.log(response);
            }
        });

    }

    function orderItems() {
        var itemElems = $grid.packery('getItemElements');
        $( itemElems ).each( function( i, itemElem ) {
            var inputArr = $(itemElem).find(':input');
            var left = $(itemElem).css('left');
            var top = $(itemElem).css('top');
            var input1 = $(inputArr[0]);
            input1.val(i + 1);
            var input2 = $(inputArr[1]);
            input2.val(left);
            var input3 = $(inputArr[2]);
            input3.val(top);

            save_main_options_ajax();
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
                repeat_header.append("<th>" + this.headers[j] + "</th>");
            }

            // remove appended headers by classname.
            $("tr.repeated-header",table).remove();

            // loop all tr elements and insert a copy of the "headers"
            for(var i = 1; i < table.tBodies[0].rows.length; i++) {

                // insert a copy of the table head every 5th row
                if((i % 4) === 0) {
                    $("tbody tr:eq(" + i + ")").before(
                        repeat_header
                    );
                }
            }
        }
    });

    $("#accountsTable").tablesorter({sortList: [[0,0]], widgets: ['zebra']});

    $("#contactsTable").tablesorter({sortList: [[4,0],[1,0]], widgets: ['zebra']});

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