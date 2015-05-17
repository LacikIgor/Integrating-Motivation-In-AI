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


// CONSTANT VALUES
var EMPTY  = "0";
var AGENT  = "1";
var DANGER = "2";
var TOY    = "3";
var BED    = "4";
var FOOD   = "5";

// CONSTANT COLORS
var EMPTY_COLOR  = "#FFFFFF";
var AGENT_COLOR  = "#000000";
var DANGER_COLOR = "#F52500";
var TOY_COLOR    = "#3077DD";   
var BED_COLORS   = "#0000FE";
var FOOD_COLORS  = "#80EA0E";

var EMPTY_TITLE  = "Empty";
var AGENT_TITLE  = "Agent";
var DANGER_TITLE = "Danger";
var TOY_TITLE    = "Toy";
var FOOD_TITLE   = "Food";
var SLEEP_TITLE  = "Sleep";
/*
 * @param {int} value
 */
function getMyColor( value )
{
    var result = "";
    switch ( value )
    {
        case EMPTY:
            result = EMPTY_COLOR;
            break;
        case AGENT:
            result = AGENT_COLOR;
            break;
        case DANGER:
            result = DANGER_COLOR;
            break;
        case TOY:
            result = TOY_COLOR;
            break;
        case BED:
            result = BED_COLORS;
            break;
        case FOOD:
            result = FOOD_COLORS;
            break;
        default:
            alert( "Color/Value error! val = " + value );
            result = "#000";
            break;
    }
    return result;
} // getMyColor

/**
 * @param {string} val
 * @returns {String}
 */
function getTitle( val )
{
    var result = "";
    switch ( val )
    {
        case EMPTY:
            result = EMPTY_TITLE;
            break;
        case AGENT:
            result = AGENT_TITLE;
            break;
        case DANGER:
            result = DANGER_TITLE;
            break;
        case TOY:
            result = TOY_TITLE;
            break;
        case BED:
            result = SLEEP_TITLE;
            break;
        case FOOD:
            result = FOOD_TITLE;
            break;
        default:
            result = "";
    }
    return result;
}; // getTitle

/**
 * @param {string} val
 * @returns {String}
 */
function getActionTitle( val )
{
    var result = "";
    switch ( val )
    {
        case EMPTY:
            result = "NONE";
            break;
        case AGENT:
            result = "NONE";
            break;
        case DANGER:
            result = "NONE";
            break;
        case TOY:
            result = "Play";
            break;
        case BED:
            result = "Sleep";
            break;
        case FOOD:
            result = "Eat";
            break;
        default:
            result = "";
    }
    return result;
}; // getActionTitle

/**
 * Help function for JS foreach loop
 * @param {Array} array
 * @param {index} prop
 * @returns {RegExp}
 */
function arrayHasOwnIndex( array, prop ) 
{
    return array.hasOwnProperty(prop) && /^0$|^[1-9]\d*$/.test(prop) && prop <= 4294967294; // 2^32 - 2
} // arrayHasOwnIndex

/**
 * Makes the color darker/lighter according to the percent used
 * @param {String} color in hexa
 * @param {int} percent
 * @returns {String}
 */
function shadeColor( color, percent ) 
{
    var R = parseInt( color.substring( 1,3 ), 16 );
    var G = parseInt( color.substring( 3,5 ), 16 );
    var B = parseInt( color.substring( 5,7 ), 16 );

    R = parseInt( R * ( 100 + percent ) / 100 );
    G = parseInt( G * ( 100 + percent ) / 100 );
    B = parseInt( B * ( 100 + percent ) / 100 );

    R = ( R < 255 ) ? R : 255;  
    G = ( G < 255 ) ? G : 255;  
    B = ( B < 255 ) ? B : 255;  

    var RR = ( ( R.toString( 16 ).length === 1 ) ? "0" + R.toString( 16 ) : R.toString( 16 ) );
    var GG = ( ( G.toString( 16 ).length === 1 ) ? "0" + G.toString( 16 ) : G.toString( 16 ) );
    var BB = ( ( B.toString( 16 ).length === 1 ) ? "0" + B.toString( 16 ) : B.toString( 16 ) );

    return "#" + RR + GG + BB;
} // shadeColor

/**
 * Returns true if n is/can be integer
 * @param {String} n
 * @returns {Boolean}
 */
function isInt( n ) 
{
   return n % 1 === 0;
} // isInt