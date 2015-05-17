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

/**
 * ############################################################################
 * ####### This class implements the action Move which manipulates    #########
 * ####### the agents coordinates in the map as well as it's needs.   #########
 * ####### The Map is a toroid, so the move action acts accordingly.  #########
 * ############################################################################
 */

/**
 * @param {Agent} agent
 * @param {JSON} action
 * @returns {undefined}
 */
function MoveAction( agent, action ) {
    this.agent = agent;
    this.title = action.name;

    this.boredom_inc     = action.boredom_inc;
    this.hunger_inc      = action.hunger_inc;
    this.pain_inc        = action.pain_inc;
    this.playfulness_inc = action.playfulness_inc;
    this.tiredness_inc   = action.tiredness_inc;
    this.max_step_num    = action.max_step_num;
} // constructor MoveAction

/**
 * toString
 */
MoveAction.prototype.toString = function() {
    var result = "\n";
    result += this.title;
    result += "\n";
    result += "Hunger: " + this.hunger_inc + "\n";
    result += "Tired: " + this.tiredness_inc + "\n";
    result += "Pain: " + this.pain_inc + "\n";
    result += "Play: " + this.playfulness_inc + "\n";
    return result;
}; // toString  

/**
 * @param {String} direction
 */
MoveAction.prototype.move = function( direction ) {
    var _that = this;
    this.agent.lastAction = direction;
    _that.affectAgent();
    switch( direction ) {
        case "Up":
            _that.setAgentFieldValue( 
                this.agent.x,
                _that.getUpY()
            )
            _that.moveUp();
            break;
            
        case "Down":
            _that.setAgentFieldValue( 
                this.agent.x,
                _that.getDownY()
            )
            _that.moveDown();
            break;
            
        case "Left":
            _that.setAgentFieldValue( 
                _that.getLeftX(),
                this.agent.y
            )
            _that.moveLeft();
            break;
            
        case "Right":
            _that.setAgentFieldValue( 
                _that.getRightX(),
                this.agent.y
            )
            _that.moveRight();
            break;
        default:
            console.log( "ERROR IN MOVE!! Default selected => " + direction );
    }
}; // move

MoveAction.prototype.getUpY = function() {
    var tmp_y = this.agent.y;
    if ( tmp_y < 1 ) {
        return this.agent.map.size - 1;
    }
    return --tmp_y;
}; // getUpY

MoveAction.prototype.moveUp = function() {
    var _that = this;
    this.agent.y = _that.getUpY();
}; // moveUp

MoveAction.prototype.getDownY = function() {
    var tmp_y = this.agent.y; 
    if ( tmp_y ===  this.agent.map.size - 1 ) {
        return 0;
    }
    return ++tmp_y;
}; // getDownY

MoveAction.prototype.moveDown = function() {
    var _that = this;
    this.agent.y = _that.getDownY();
}; // moveDown

MoveAction.prototype.getLeftX = function() {
    var tmp_x = this.agent.x;
    if ( tmp_x < 1 ) {
        return this.agent.map.size - 1;
    }
    return --tmp_x;
}; // getLeftX

MoveAction.prototype.moveLeft = function() {
    var _that = this;
    this.agent.x = _that.getLeftX();
}; // moveLeft

MoveAction.prototype.getRightX = function() {
    var tmp_x = this.agent.x;
    if ( tmp_x === this.agent.map.size - 1 ) {
        return 0;
    }
    return ++tmp_x;
}; // getRightX

MoveAction.prototype.moveRight = function() {
    var _that = this;
    this.agent.x = _that.getRightX();
}; // moveDown

MoveAction.prototype.affectAgent = function() {
    this.agent.hunger      += Number( this.hunger_inc );
    this.agent.tiredness   += Number( this.tiredness_inc );
    this.agent.pain        += Number( this.pain_inc );
    this.agent.boredom     += Number( this.boredom_inc );
    this.agent.playfulness += Number( this.playfulness_inc );
    if ( this.agent.hunger < 0 ) {
        this.agent.hunger = 0;
    }
    if ( this.agent.tiredness < 0 ) {
        this.agent.tiredness = 0;
    }
    if ( this.agent.pain < 0 ) {
        this.agent.pain = 0;
    }
    if ( this.agent.boredom < 0 ) {
        this.agent.boredom = 0;
    }
    if ( this.agent.playfulness < 0 ) {
        this.agent.playfulness = 0;
    }
}; // affectAgent

/**
* {Integer} next_x the value of the node the agent is about to step on
* {Integer} next_y the value of the node the agent is about to step on
*/
MoveAction.prototype.setAgentFieldValue = function( next_x, next_y ) {
    this.agent.agent_field_val = this.agent.map.getNode( next_x, next_y ).getVal();
}; // setAgentFieldValue