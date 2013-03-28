<?php ?>
<form>
<?php echo $this->form->field('title', array('label'=>'Title','class'=>'span9','value'=>$title)); ?>
Content:<br>
<?php echo $this->form->textarea('content',array( 'class'=>'ckeditor'));?>
<?php echo $this->form->field('tags', array('label'=>'Tags (comma seperated)','class'=>'span9','value'=>$tags)); ?>
<?php echo $this->form->field('author', array('label'=>'Author','class'=>'span2','value'=>$author)); ?>
</form>