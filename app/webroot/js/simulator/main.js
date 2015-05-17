/* 
 * The MIT License
 *
 * Copyright 2014 Igor Lacik.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation and source code files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The Software shall be used for Good, not Evil.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/* #############################################################################
 * ##################   GUI IMPLEMENTATION FOR THE SIMULATOR   #################
 * ############################################################################# 
 */

 // Change history:
 // ilacik 1.0 -> Initial Release 

// init
$( '#edit_toggle' ).attr( 'checked', false );
$( '#size_input' ).val( '5' );
$( '#options_form' ).hide();
var is_edit_map    = false;
var selected_value = "0"; 
var canvas  = document.getElementById( 'simulator_canvas' );
var str_rep = active_representation;
var environment = new Map( str_rep, active_agent, canvas );
var is_started = false;
// end init

/**
 * Clicking on the checkbox Edit map the session changes from observing
 * agent to editing the map. A 5*5 empty map is created defaultly. 
 */
$( 'body' ).on( 'change', '#edit_toggle', function()  {
    if ( $( '#edit_toggle' ).is( ':checked' ) ) {
        $( '#start_form' ).hide();
        $( '#options_form' ).show();
        str_rep = getEmptyRepresentation( 5 );
        is_edit_map = true;
        is_started = false;
        environment = new Map( str_rep, active_agent, canvas );
    }
    else {
        is_edit_map = false;
        $( '#options_form' ).hide( 1000 );
        $( '#start_form' ).show( 1000 );
    }
} ); // change #edit_toggle

/**
 * On size_input change create an empty map with size*size nodes
 */
$( 'body' ).on( 'change', '#size_input', function() {
    if ( isInt( $( '#size_input' ).val() ) ) {
        str_rep = getEmptyRepresentation( $( '#size_input' ).val() );
        environment = new Map( str_rep, active_agent, canvas );
    }
} ); // change size input

/**
 * After clicking on a radio button, user is able to set
 * nodes in the map to selected value.
 */
$( "input:radio" ).click( function() {
    selected_value = $( this ).val();
}); // select type of node to paint

/**
 * @param {int} size
 * @returns {String}
 *      => Returns an empty map representation
 *      => Format as in world/map.js constructor
 */
function getEmptyRepresentation( size ) {
    var result = '';
    for ( var i = 0; i < size; i++ ) {
        for ( var j = 0; j < size; j++ ) {
            if ( j !== 0 ) {
                result += ' ' + EMPTY;
            }
            else {
                result += EMPTY;
            }
        }
        if ( i !== size-1) {
            result += ',';
        }
    }
    return result;
} // getEmptyRepresentation

/*
 * Save the map representation to the active Scenario record
 */
$( '#options_form input:submit' ).click( function( e ) {
   e.preventDefault();
   if ( confirm( 'Are you sure you want to save this map for this scenario?' ) ) {
       var representation  = environment.getStringRepr();
       $.ajax ( {
            type: "POST",
            url: './Scenarios/saveMapChanges',
            data: 
            {
                representation  : representation 
            },
            context: document.body,
            async: false
        }).done( function() {
            alert( "Successfully saved" );
            // window.location = "http://localhost/actor_critic";
            window.location = "http://www.actorcritic.sk/";
        } );
   }
}); // save map scenario

var dis_plot = $.plot (
    "#time_need_distance_plot", 
    [getData( "distance", 300, 5000 )], {
        series: {
            shadowSize: 0
	    },
	    yaxis: {
            min: 0,
            max: 5000,
            reserveSpace: false
	    },
	    xaxis: {
            show: false
	    }
    }
); // dis_plot

var reward_plot = $.plot (
    "#reward_plot", 
    [getData( "reward", 300, 10 )], {
        series: {
            shadowSize: 0
	    },
	    yaxis: {
            min: -10,
            max: 10,
            reserveSpace: true
	    },
	    xaxis: {
            show: false
	    }
    }
); //reward_plot

var sum_squared_plot =  $.plot (
    "#sum_squared_err",
    [getData( "sum_squared", 300, 300 )], {
        series: {
            shadowSize: 0
        },
        yaxis: {
            min: 0,
            max: 300
        },
        xaxis: {
            show: false
        }
    }
); // sum_squared_plot

function getData( data_type, _max, _max_y ) {
    var data = environment.getAgentData( data_type );
    if ( data === undefined ) 
        return [];
    var max = _max;
    if ( data.length > max ) {
        var delta = data.length - max;
        for ( var j = 0; j < delta; j++ ) {
            data.shift();
        }
    }
    var res = [];
    for ( var i = 0; i < max; i++ ) {
        if ( data.length-1 < i ) {
            res.push( [i, 0 ] );
        }
        else {
            if ( data[i] > _max_y ) {
                data[i] = _max_y;
            }
            res.push( [i, data[i]] );
        }
    }
    return res;
} // getData

function updatePlot() {
    dis_plot.setData( [ getData( "distance", 300, 5000 ) ] );
    dis_plot.draw();
    reward_plot.setData( [ getData( "reward", 300, 10 ) ] );
    reward_plot.draw();
    sum_squared_plot.setData( [ getData( "sum_squared", 300, 300 ) ] );
    sum_squared_plot.draw();
    setTimeout( updatePlot, $( "#speed" ).val() );
} // updatePlot

$( 'body' ).on( 'click', '#start_button', function( e ) {
   e.preventDefault();
   if ( 
        ( $( this ).val() === 'Start simulation' ) || 
        ( $( this ).val() === 'Continue' ) 
      ) {
        if ( !is_started ) {
            environment.getAgent().initAI( active_agent );
            is_started = true;
        }
       environment.start( $( "#speed" ).val() );
       $( "#speed_span" ).hide( 500 );
       $( this ).val( 'Pause' );
        updatePlot();
   }
   else {
       updatePlot();
       environment.pause();
       $( "#speed_span" ).show( 500 );
       $( this ).val( 'Continue' );
   }
}); // toggle start, continue, pause

$( 'body' ).on( 'click', '#save_data_button', function() {
    var req_data = {
        agent_logs : [{
            name     : $( "#data_name" ).val(),
            note     : $( "#data_note" ).val(),
            agent_id : environment.getAgent().getID(),
            log_json : JSON.stringify( environment.getAgent().getLogs() )
        }]
    };
    $.ajax ({
        type: "POST",
        url: "http://www.actorcritic.sk/Logs/add",
        data: req_data, 
        context: document.body,
        success: function() {
            alert( "Logs were saved" );
        },
        error: function() {
            $.ajax ({
                type: "POST",
                url: "http://actorcritic.sk/Logs/add",
                data: req_data, 
                context: document.body,
                success: function() {
                    alert( "Logs were saved" );
                }
            });
        }
    });
    
} ); // save logs

$( 'body' ).on( 'click', '#random_agent', function() {
    console.log( "Change random" );
    if ( this.checked ) {
        environment.agent.is_random = true;
    }
    else {
        environment.agent.is_random = false;   
    }
} ); // checkRandomAgent