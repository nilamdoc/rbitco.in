<h4>Add a new bank:</h4>
<?=$this->form->create('',array('url'=>'/users/addbankdetails')); ?>
<?=$this->form->field('bankname', array('label'=>'1. Bank name','placeholder'=>'Bank name' )); ?>
<?=$this->form->field('accountnumber', array('label'=>'2. Account number','placeholder'=>'Account number' )); ?>
<?=$this->form->field('branchname', array('label'=>'3. Branch name','placeholder'=>'Branch name' )); ?>
<?=$this->form->field('micrnumber', array('label'=>'4. MICR number','placeholder'=>'MICR number' )); ?>
<?=$this->form->field('accountname', array('label'=>'5. Account name','placeholder'=>'Account name' )); ?>
<?=$this->form->submit('Save bank',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
<img src="/img/BankCheque.png">