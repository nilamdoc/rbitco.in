<h4>Messages</h4>
<div class="accordion" id="accordion2" style="background-color:#FFFFFF">
<div class="accordion-group">
  <div class="accordion-heading">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseInbox">	
	Inbox: <?=$countMails['count'];?> messages</a>
  </div>
  <div id="collapseInbox" class="accordion-body collapse">
	<div class="accordion-inner">
	<h6>Inbox</h6>
	<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>From</th>
			<th>Message</th>
			<th>Date</th>			
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($getMails as $gm){
	?>
	<tr>
		<td><?=$gm['fromUser']?></td>
		<td><?=$gm['message']?></td>		
		<td><?=$gm['datetime']['date']?> <?=$gm['datetime']['time']?></td>				
		<td>
		<a href='/users/message/<?=$gm['refer_id']?>/<?=$gm['user_id']?>/1' class='label label-warning' rel='tooltip' title='Reply' >Reply</a>
		<a href='/messages/markasread/<?=$gm['_id']?>/1' class='label label-warning' rel='tooltip' title='Mark as read' >Mark as read</a>		
		</td>
	</tr>
	<?php
		}
	 ?>
	 </tbody>
	 </table>
	</div>
  </div>
  <div class="accordion-heading">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSent">	
	Sent: <?=$countSendMails['count'];?> messages</a>
  </div>
  <div id="collapseSent" class="accordion-body collapse">
	<div class="accordion-inner">
	<h6>Sent</h6>
	<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>To</th>
			<th>Message</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($getSendMails as $gm){
	?>
	<tr>
		<td><?=$gm['toUser']?></td>
		<td><?=$gm['message']?></td>		
		<td><?=$gm['datetime']['date']?> <?=$gm['datetime']['time']?></td>						
		<td>
		<a href='/messages/markasdelete/<?=$gm['_id']?>/1' class='label label-warning' rel='tooltip' title='Delete' >Delete</a>		
		</td>
	</tr>
	<?php
		}
	 ?>
	 </tbody>
	 </table>
	</div>
  </div>
  <div class="accordion-heading">
	<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseRead">	
	Read: <?=$countReadMails['count'];?> messages</a>
  </div>
  <div id="collapseRead" class="accordion-body collapse">
	<div class="accordion-inner">
	<h6>Read</h6>
	<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>From</th>
			<th>Message</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($getReadMails as $gm){
	?>
	<tr>
		<td><?=$gm['fromUser']?></td>
		<td><?=$gm['message']?></td>		
		<td><?=$gm['datetime']['date']?> <?=$gm['datetime']['time']?></td>						
		<td>
		<a href='/messages/markasdelete/<?=$gm['_id']?>/1' class='label label-warning' rel='tooltip' title='Delete' >Delete</a>				</td>
	</tr>
	<?php
		}
	 ?>
	 </tbody>
	 </table>
	
	</div>
  </div>
</div>
</div>
<h4>Help:</h4>
<p>You can not write direct messages to users. You can only write messages to your parents / children nodes. To write messages to them check your <a href="/users/accounts">accounts</a> page.</p>
<h5>Reading messages:</h5>
<p>Reading a message and storing it as read messages, will give you <span class="label label-warning">1</span> bronze point.</p>
<h5>Reply to:</h5>
<p>Replying a message will give you <span class="label label-warning">2</span> bronze points.</p>
<h5>Deleting messages</h5>
<p>Keep you inbox clean, once you have read and message, replied to the sender, it is always advisable to delete the message permentaly. If you delete 10 messages, you will get <span class="label label-warning">1</span> bronze point.</p>
<h6>You can keep collecting points, soon the points will increase, check the points table to get the advantages from referrals</h6>