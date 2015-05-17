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
 * #############################################################################
 * ####### This class implements the object Node which represents the  #########
 * ####### one field in the environment map.                           #########
 * #############################################################################
 */

/**
 * 
 * @param {Map} map
 * @param {int} value
 * @param {int} size
 * @param {int} x
 * @param {int} y
 * @returns {Node}
 */
function Node( map, value, size, x, y )
{
    this.map   = map;
    this.map.foo = 10;
    this.value = value;
    this.size  = size;
    this.x     = x;
    this.y     = y;
    this.color = getMyColor( this.value );
    this.width = map.canvas.width / size;

    this.depth = 0;
    
    this.hunger      = 0;
    this.tiredness   = 0;
    this.pain        = 0;
    this.playfulness = 0;
    this.range       = 0;
    
    this.title = getTitle( this.value );
    
    this.setNeedVals();
    
} // Node

/**
 * Sets the needs vals for this node according 
 * to the global JSON OBJECT active_objects
 */
Node.prototype.setNeedVals = function()
{
    for ( var i = 0; i < active_objects.length; i++ )
    {
        if ( this.title === active_objects[i].title )
        {
            this.hunger      = active_objects[i].hunger_inc;
            this.tiredness   = active_objects[i].tiredness_inc;
            this.pain        = active_objects[i].pain_inc;
            this.playfulness = active_objects[i].playfulness_inc;
            this.range       = active_objects[i].env_obj_range;
        }
    }
}; // setNeedVals

/**
 * If the node represents the starting position of the agent
 * draw it only if the flag is on (E.G. editMap mode). 
 * 
 * If the flag is off (!also_agent) draw an empty node instead.
 * 
 * @param {boolean} darken
 * @param {boolean} also_agent
 * Draws the node on it's position on the map 
 */
Node.prototype.drawNode = function( darken, also_agent )
{
    if ( ( this.value === AGENT ) && ( !also_agent ) )
    {
        this.color = EMPTY_COLOR;
    }
    
    if ( darken )
    {
        this.map.ctx.fillStyle = shadeColor( this.color, -70 );
    }
    else
    {
        this.map.ctx.fillStyle = this.color;
    }
    this.map.ctx.fillRect
    (
        this.x * this.width,
        this.y * this.width,
        this.width,
        this.width
    );
    
    this.map.ctx.strokeStyle = "#000";
    this.map.ctx.strokeRect
    ( 
        this.x * this.width, 
        this.y * this.width,
        this.width,
        this.width
    );
    
    this.map.ctx.fillStyle = "#000";
    this.map.ctx.font = this.width/3 + "px Arial";
    var text = "";
    if  ( this.title != EMPTY_TITLE && this.title != AGENT_TITLE )
    {
        text = this.title[0];
    }
    this.map.ctx.fillText
    (
        text,
        this.x * this.width + 1.2 * this.width/3,
        this.y * this.width + 1.7 * this.width/3
    );
    
    if ( this.pain > 0 )
    {
        var danger_color = DANGER_COLOR;
        if ( darken ) 
            danger_color = shadeColor( danger_color, -70 );
        this.map.ctx.fillStyle = danger_color;
        this.map.ctx.beginPath();
        this.map.ctx.arc( 
            this.x * this.width + ( this.width / 2 ),
            this.y * this.width + ( this.width / 2 ),
            this.width / 5,
            0,
            2 * Math.PI,
            true
        );
        this.map.ctx.closePath();
        this.map.ctx.fill();
    }
    
}; // drawNode


/**
 * @param {int} value
 */
Node.prototype.setVal = function( value )
{
    this.value = value;
    this.color = getMyColor( value );
}; // setVal

Node.prototype.getVal = function()
{
    return this.value;
}; // getVal

/**
 * 
 * @param {int} e_x
 * @param {int} e_y
 * @returns {boolean}
 *      return true if the point e_x, e_y is
 *      inside the Node
 */
Node.prototype.isClickedNode = function( e_x, e_y )
{
    if ( 
         ( ( this.x * this.width ) < e_x )              && 
         ( ( this.x * this.width + this.width ) > e_x ) &&
         ( ( this.y * this.width ) < e_y )              &&
         ( ( this.y * this.width + this.width ) > e_y )
        )
    {
        return true;
    }
    return false;
}; // isClickedNode

/**
 * @returns {String}
 */
Node.prototype.toString = function()
{
    var result = "\n";
    result += this.value;
    result += " : ";
    result += this.title;
    result += "\n";
    result += "Hunger: " + this.hunger + "\n";
    result += "Tired: " + this.tiredness + "\n";
    result += "Pain: " + this.pain + "\n";
    result += "Play: " + this.playfulness + "\n";
    result += "Range: " + this.range + "\n";
    result += "X: " + this.x + " Y: " + this.y +  "\n";
    return result;
}; // toString

/**
 * Distribute the strength of needs to all neighbouring nodes
 */
Node.prototype.affectNeighbours = function()
{
    var neighbours = getVisibleNodes ( 
        this, 
        this.range, 
        this.map.nodes, 
        this.map.size 
    );
    
    for ( var i = 0; i < neighbours.length; i++ )
    {
        if ( isSameNode( this, neighbours[i] ) )
        {
            continue;
        }
        
        if ( this.value == FOOD )
        {
            neighbours[i].hunger      = Number( neighbours[i].hunger ) + 
                                       ( Number( this.hunger ) * 0.8 );
        }
        
        if ( this.value == DANGER )
        {
            neighbours[i].pain        = Number( neighbours[i].pain ) + 
                                       ( Number( this.pain ) * 0.8 );
        }
        
        if ( this.value == TOY )
        {
            neighbours[i].playfulness = Number( neighbours[i].playfulness ) + 
                                        ( Number( this.playfulness ) * 0.8 );
        }
    }
}; // affectNeighbours