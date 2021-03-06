<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License

 */
 use lithium\storage\Session;
?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title>Bitcoin Magazine:&gt; <?php if(isset($title)){echo $title;} ?></title>
	<?php echo $this->html->style(array('/bootstrap/css/bootstrap')); ?>
	<?php echo $this->html->style(array('/bootstrap/css/bootstrap-responsive')); ?>	
	<?php echo $this->html->style(array('/bootstrap/css/docs')); ?>	
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
	<?php
	$this->scripts('<script src="/bootstrap/js/jquery.js"></script>'); 
	$this->scripts('<script src="/js/rbitcoin.js"></script>'); 	
	$this->scripts('<script src="/bootstrap/js/application.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-affix.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-alert.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-button.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-carousel.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-collapse.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-dropdown.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-modal.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-tooltip.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-popover.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-scrollspy.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-tab.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-transition.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-typeahead.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap.min.js"></script>'); 
	$this->scripts('<script src="/ckeditor/ckeditor.js"></script>');
	?>   		
	<?php echo $this->scripts(); ?>	
</head>
<body>
	<div id="container" class="container"  style="width:96%;border-left: 1px solid gray;border-right: 1px solid gray;padding:10px">
		<?php 	echo $this->_render('element', 'mag-header');?>
		<div id="content" class="container"  style="width:97%;margin-top:20px" >
			<div class="row">
				<div class="span9 well" style="border:1px solid gray "><?php echo $this->content(); ?></div>
			</div>
		</div>
	</div>
	<?php 	echo $this->_render('element', 'footer');?>				
<script >
$(function() {
	$('.tooltip-x').tooltip();
});
//if (top.location!= self.location) {
//	top.location = self.location.href;
//}
</script>
</body>
</html>