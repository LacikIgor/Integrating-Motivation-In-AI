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
 * ##################   PLAY IMPLEMENTATION FOR THE SIMULATOR   #################
 * ############################################################################# 
 */

 // Change history:
 // ilacik 1.0 -> Initial Release 

/**
 * ############################################################################
 * ####### This class implements the action Play                      #########
 * ############################################################################
 */

/**
 * @param {Agent} _agent
 * @param {JSON} _action
 * @returns {undefined}
 */
function PlayAction( _agent, _action )
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

    this.play_thr_const      = Number( _agent.play_thr_const );
    this.play_thr_rand       = Number( _agent.play_thr_rand );
} // constructor MoveAction

/**
 * toString
 */
PlayAction.prototype.toString = function()
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

PlayAction.prototype.affectAgent = function( intensity )
{
    this.agent.hunger      += Number( this.hunger_inc );
    this.agent.tiredness   += Number( this.tiredness_inc );
    this.agent.pain        += Number( this.pain_inc );
    this.agent.boredom     += Number( this.boredom_inc );
    this.agent.playfulness += Number( this.playfulness_inc );

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
    this.agent.lastAction  = this.title;
}; // affectAgent

PlayAction.prototype.affectWithIntensity = function( intensity ) {
    if ( ( intensity > this.play_thr_const ) && ( intensity < this.play_thr_rand ) ) {
        this.agent.playfulness -= this.const_play_dec;
        this.title = "Play constant: " + intensity;
    }
    else if ( intensity > this.play_thr_rand ) {
        this.agent.playfulness -= Math.floor( ( Math.random() * this.max_random_play_dec ) + 1 );
        this.title = "Play random: " + intensity;
    }
    else {
        this.title = "Play not enough intensity: " + intensity;
    }
}; // affestWithIntensity