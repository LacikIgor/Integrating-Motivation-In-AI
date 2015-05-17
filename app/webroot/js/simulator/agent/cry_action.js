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
 * ##################   CRY IMPLEMENTATION FOR THE SIMULATOR   #################
 * ############################################################################# 
 */

 // Change history:
 // ilacik 1.0 -> Initial Release 

/**
 * ############################################################################
 * ####### This class implements the action Cry                      #########
 * ############################################################################
 */

/**
 * @param {Agent} _agent
 * @param {JSON} _action
 * @returns {undefined}
 */
function CryAction( _agent, _action )
{
    this.agent = _agent;
    this.title = _action.name;

    this.boredom_inc         = Number( _action.boredom_inc );
    this.hunger_inc          = Number( _action.hunger_inc );
    this.pain_inc            = Number( _action.pain_inc );
    this.playfulness_inc     = Number( _action.playfulness_inc );
    this.tiredness_inc       = Number( _action.tiredness_inc );
    this.const_play_dec      = Number( _action.const_play_dec );
    this.max_random_play_dec = Number( _action.max_random_play_dec );
    this.cry_hunger_dec = Number( _action.cry_hunger_dec );

    this.cry_thr_eat    = Number( _agent.cry_thr_eat );
    this.cry_thr_danger = Number( _agent.cry_thr_danger );
} // constructor MoveAction

/**
 * toString
 */
CryAction.prototype.toString = function()
{
    var result = "\n";
    result += this.title;
    result += "\n";
    result += "Hunger: " + this.hunger_inc + "\n";
    result += "Tired: " + this.tiredness_inc + "\n";
    result += "Pain: " + this.pain_inc + "\n";
    result += "Play: " + this.playfulness_inc + "\n";
    return result;
}; // toString  

CryAction.prototype.affectAgent = function( intensity )
{
    this.agent.tiredness   += Number( this.tiredness_inc );
    this.agent.pain        += Number( this.pain_inc );
    this.agent.boredom     += Number( this.boredom_inc );
    this.agent.playfulness += Number( this.playfulness_inc );
    this.agent.hunger += Number( this.hunger_inc );

    this.affectWithIntensity( intensity );

    if ( this.agent.hunger < 0 )
    {
        this.agent.hunger = 0;
    }
    if ( this.agent.tiredness < 0 )
    {
        this.agent.tiredness = 0;
    }
    if ( this.agent.pain < 0 )
    {
        this.agent.pain = 0;
    }
    if ( this.agent.boredom < 0 )
    {
        this.agent.boredom = 0;
    }
    if ( this.agent.playfulness < 0 )
    {
        this.agent.playfulness = 0;
    }
    this.agent.lastAction = this.title;
}; // affectAgent

CryAction.prototype.affectWithIntensity = function( intensity ) {
    if ( ( intensity > this.cry_thr_eat ) && ( intensity < this.cry_thr_danger ) ) {
        this.agent.hunger -= Math.abs( Number( this.cry_hunger_dec ) );
        this.title = "Cry was fed: " + intensity.toFixed( 2 );
    }
    else if ( intensity > this.cry_thr_danger ) {
        this.moveAwayFromDanger( intensity );
    }
    else {
        this.title = "Cry - not enough intensity: " + intensity.toFixed( 2 );
    }
}; // affestWithIntensity

CryAction.prototype.moveAwayFromDanger = function( intensity ) {
    if ( this.agent.map.getNode( this.agent.x, this.agent.y ).pain == 0 ) {
        this.title = "Cry for move - no need to move: " + intensity.toFixed( 2 );
        return;
    }
    this.title = "Cry was carried away: " + intensity.toFixed( 2 );
    var surroundingNodes = getVisibleNodes( 
        this.agent.map.getNode( this.agent.x, this.agent.y ),
        1,
        this.agent.map.nodes,
        this.agent.map.size
    );
    var noDangerNode = this.getNoDangerNode( surroundingNodes );
    if ( noDangerNode == undefined ) {
        noDangerNode = this.getNoDangerNode( this.agent.map.nodes );
    }
    if ( noDangerNode != undefined ) {
        var field_val = this.agent.map.getNode( noDangerNode.x, noDangerNode.y ).getVal();
        this.agent.agent_field_val = field_val;
        this.agent.x = noDangerNode.x;
        this.agent.y = noDangerNode.y;
    }
}; // moveAwayFromDanger

CryAction.prototype.getNoDangerNode = function( nodes ) {
    for ( var x = 0; x < this.agent.map.size; x++ ) {
        for ( var y = 0; y < this.agent.map.size; y++ ) {
            var node = this.agent.map.getNode( x, y );
            if ( node.pain == 0 ) {
                return node;
            }
        }
    }
    return undefined;
}; // nodesContainNoDanger