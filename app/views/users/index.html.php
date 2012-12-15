<h2>User List</h2>

<p><?=$this->html->link('Sign Up', 'Users::signup')?></p>

<?php if($users->count()) { ?>
<ul>
<?php foreach($users as $user) { ?>
<li><?=$user->name?></li>
<?php } ?>
</ul>
<?php } ?>