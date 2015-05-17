<?php
    $cakeDescription = __d( 'cake_dev', 'Computational model of intrinsic and extrinsic motivation for decision making and action-selection' );
?>

<!DOCTYPE html>
<html>
    <head>
	<?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $title_for_layout; ?>
        </title>
	<?php
            echo $this->Html->meta( 'icon' );
            echo $this->Html->css( 'cake.generic' );
            echo $this->Html->script
            ( 
                array
                (
                    'plugins/jquery-1.8.3.min',
                    'plugins/picnet.table.filter.min',
                    'data/main'
                )
            );
            echo $this->fetch( 'meta' ); 
            echo $this->fetch( 'css' );
            echo $this->fetch( 'script' );
	?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1><?php echo $this->Html->link( $cakeDescription, 'http://www.actorcritic.sk' ); ?></h1>
            </div>
            <div id="content">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
                <p>
                &copy;2013-<?php echo date("Y"); ?> Igor Lacík for Indre Pileckyte and Martin Takáč of Faculty of Mathematics, Physics and Informatics, Comenius University, Center for Cognitive Science
                </p>
                <p>
                    Special thanks to our hosting sponsor <a href="http://awd.sk/web/src/index.php" style="color:#600505;">AWD Systems s.r.o.</a>.
                </p>
            </div>
            <div class="modal_wait"></div>
        </div>
	<?php //echo $this->element('sql_dump'); ?>
    </body>
</html>