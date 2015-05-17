<html>
    <head>
        <title>JS Neural Network Demonstration</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <?php
            echo $this->Html->script
            (
                array
                (
                    'simulator/brain/mlp/mlp.min.js',
                    'simulator/brain/mlp/MLPTest.js'
                )
            );
        ?>
        <style type="text/css">
            #logs_container {
                float: left;
                min-height: 400px;
                width: 70%;
            }
            #form_container {
                float: left;
                min-height: 400px;
                width: 70%;
            }
            body {
                margin-left: 5%;
            }
            div {
                float: left;
                width: 100%;
            }
            code  {
                font-family: consolas, courier, monospace;
                font-size: 0.8em;
                line-height: 1em;
                white-space: pre; 
                background-color: #eee;
                color: #000; /* likewise the background-color comment */
                border: 1px solid #666;
                -moz-border-radius: 1em;
                -webkit-border-radius: 1em;
                border-radius: 1em; /* just in case */
                padding: 1em;
                margin: 1.2em 1em;
                width: 80%; /* or whatever you prefer */
                overflow: auto;
                float: left;
            }

            div > footer {
                border-top: 1px solid #DDD;
                padding: 10px;
                font-size: 0.7em;
            }
        </style>
    </head>
    <body><header>
            <h1>MultiLayer Perceptron Vanilla JS Demonstration</h1>
            <div>
            <p>
                <a href="http://en.wikipedia.org/wiki/Multilayer_perceptron">Multilayer perceptron</a> is well described on its wiki website. 
                It can be used for categorizing or machine-learning values of non-linear data. This microsite demonstrates
                categorization on the classic test case scenarios:  Categorizing <a href="http://en.wikipedia.org/wiki/Iris_flower_data_set"> IRIS Flowers </a> and 
                 Learning a 3 dimensional <a href="http://en.wikipedia.org/wiki/Exclusive_or"> XOR function </a>.
            </p>
            <p>
                Multiple dimensions are supported and the quality of learning depends on the neural network architecture you choose. The MLP is modular enough to be
                integrated into other solutions such as in my diploma titled <a href="http://www.actorcritic.sk/">Model of Decision Making Using Reinforcement Learning </a>.
            </p>
            <p><a href="http://en.wikipedia.org/wiki/Multilayer_perceptron">Multilayer perceptron</a> is well described on its wiki website.</p>
            <h2> Categorizing IRIS Flower dataset </h2>
            <h3> How to initialize training? </h3>
            </div> </header>
<code>
var _inputNeuronCount  = 4; // 4 dimensional input (4 parameters)
var _hiddenNeuronCount = 6; // The number of hidden layers makes the network more flexible
var _outputNeuronCount = 3; // The number of categories
var _hidActvt = SGM; // activation function for the hidden layer -> use SGM for sigmoid or TANH for hyperbolic tangens 
var _outActvt = LIN; // activation function for the output layer -> mostly use linear for output
var _alpha = 0.1; // in most scenarios not necessary to change
var _beta  = 0.0; // in most scenarios not necessary to change

var predefined_weight_values = undefined; // if undefined than they are chosen randomly

var is_softmax = true; // for categorization use softmax (value -> true), for learning a specific output value, set to false 
mlp = new MLP( 
    _inputNeuronCount, 
    _hiddenNeuronCount, 
    _outputNeuronCount, 
    _hidActvt,
    _outActvt, 
    undefined,
    _alpha, 
    _beta,
    is_softmax
); // multilayer perceptron was constructed

// Example of one training step -> trains that a flower with these parameters is of the first category
// mlp.train( input_values_array, output_values_array );
mlp.train( [0.224000, 0.624000, 0.067000, 0.043000], [1.0, 0.0, 0.0] );
</code>
<div id="iris_test">
    <p>
        <strong>How is the categorization demonstrated? </strong>
        <ol>
            <li> We have 50 flowers of category Setosa (1.), 50 flowers of category Versicolor (2.) and 50 flowers of category Virginica </li>
            <li> We show the network 46 flowers of each category <br />
                46 times using mlp.train( [sepal_length, sepal_width, petal_length, petal_width], [0.0, 1.0, 0.0] ); <br />
                There is always only one 1.0 and the rest is 0.0. [0.0, 1.0, 0.0] means the flower belongs to the 2. category (versicolor) ) </li>
            <li> The neural network should be trained now. </li>
            <li> 
                To test it, we can propagate(almost a synonym of ask) data previously unshown to the network. <br /> 
                The output is a 3 dimensional array, the value in the array representing the category should be close to 1.0 (100%) <br /> 
                These values represent the confidence of the network that the presented flower belongs to the category
            </li>
            <li>Repeat until trained (I don't really care and train it fixed 100 times)</li>
            <li> 
                <a href="http://www.actorcritic.sk/js/simulator/brain/mlp/MLPTest.js">You can view the whole test scenario code</a> 
            </li>
        </ol>
        <button onclick=goIrisTest(); title="You can click multiple times and you will observe, that each training results are unique">DEMONSTRATE MLP CATEGORIZATION ON IRIS DATASET</button>
    </p>
</div> 
<div id="x-or">
    <h2>Learning XOR</h2>
    <p>XOR is easier to understand (until first of my viewers says otherwise), so I will only post the code of XOR with the appropriate training button:</p>
    <code>

function goXorTest()
{
    // initialize neural network
    var _inputNeuronCount  = 3;
    var _hiddenNeuronCount = 20;
    var _outputNeuronCount = 1;
    var _hidActvt = SGM;
    var _outActvt = LIN;
    var _alpha = 0.1;
    var _beta  = 0.0;

    // if undefined than they are chosen randomly
    var predefined_weight_values = undefined;
    var is_softmax = false;
    var mlp = new MLP( 
        _inputNeuronCount, 
        _hiddenNeuronCount, 
        _outputNeuronCount, 
        _hidActvt,
        _outActvt, 
        undefined,
        _alpha, 
        _beta,
        is_softmax
    );

    // train and display the results (function is the same one as the one that fires upon Train XOR click)
    document.getElementById( "x-or" ).innerHTML += mlp.testXOR();
} // goXorTest

function testXOR() {
    var self = this;
    var result="";
    for ( var j = 0; j < 500; j++ )
    {
        self.train ( [0, 0, 0], [0] );
        self.train ( [1, 0, 0], [1] );
        self.train ( [0, 1, 0], [1] );
        self.train ( [0, 0, 1], [1] );
        self.train ( [1, 1, 0], [1] );
        self.train ( [1, 0, 1], [1] );
        self.train ( [0, 1, 1], [1] );
        self.train ( [1, 1, 1], [0] );
    }

    result += "self.propagate( [0,0,0] ) neural net returns " + self.propagate( [0,0,0] );
    result += "self.propagate( [1,0,0] ) neural net returns " + self.propagate( [1,0,0] );
    result += "self.propagate( [0,1,0] ) neural net returns " + self.propagate( [0,1,0] );
    result += "self.propagate( [0,0,1] ) neural net returns " + self.propagate( [0,0,1] );
    result += "self.propagate( [1,1,0] ) neural net returns " + self.propagate( [1,1,0] );
    result += "self.propagate( [1,0,1] ) neural net returns " + self.propagate( [1,0,1] );
    result += "self.propagate( [0,1,1] ) neural net returns " + self.propagate( [0,1,1] );
    result += "self.propagate( [1,1,1] ) neural net returns " + self.propagate( [1,1,1] );

    return result;
} // testXOR
    </code>
<div>
<button onclick=goXorTest()>TRAIN XOR</button>
</div>
</div>  
<div style="margin-top: 10px;"><footer>&copy; 2013-2015 Igor Lacik (lacik.igor at gmail.com) <br />
This software is provided as is under MIT license, you may use it however you please, but I will be pleased, if you reference my github repository in your code. <br /><strong> Keep in mind that I will not be responsible for any AI apocalypse, catastrophy or mishap that might rise after (mis)using this software :-) </strong> </footer></div>
</body>
</html>