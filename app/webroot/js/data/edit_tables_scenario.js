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

$( document ).ready( function() 
{
    $( '#filtertable2' ).tableFilter();
});

$( 'body' ).on( 'change', '.db_relations .checkbox_input', function()
{
    if ( $( this ).attr( 'checked' ) )
    {
        add_agent_action_relation( $( this ).closest( 'tr' ).attr( 'id' ), $( this ).attr( 'id' ) );
    }
    else
    {
        delete_agent_action_relation( $( this ).closest( 'tr' ).attr( 'id' ), $( this ).attr( 'id' ) );
    }
});

function add_agent_action_relation( environment_object_id, scenario_id )
{
    console.log( "Update this :)" );
    $.ajax 
    ({
	type: "POST",
    // url: 'http://localhost/actor_critic/EnvironmentObjectScenarioRels/add_relation',
	url: 'http://www.actorcritic.sk/EnvironmentObjectScenarioRels/add_relation',
	data: 
        {
            environment_object_id : environment_object_id,
            scenario_id : scenario_id
        },
	context: document.body,
	async: false
    });
}

function delete_agent_action_relation( environment_object_id, scenario_id )
{
    $.ajax 
    ({
	type: "POST",
    // url: 'localhost/actor_critic/EnvironmentObjectScenarioRels/delete_relation',
	url: 'http://www.actorcritic.sk/EnvironmentObjectScenarioRels/delete_relation',
	data: 
        {
            environment_object_id : environment_object_id,
            scenario_id : scenario_id
        },
	context: document.body,
	async: false
    });
}
