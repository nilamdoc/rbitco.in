<h4>Available buy/sell deals
<a href="/transact/sell" class="label label-warning">Sell BTC</a>
<a href="/transact/buy" class="label label-success">Buy BTC</a>
</h4>
<div style="background-color:#fff;padding-top:10px;border-top:1px solid;border-bottom:1px solid  ">
	<div class="tabbable"> <!-- Only required for left/right tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">Buy</a></li>
			<li><a href="#tab2" data-toggle="tab">Sell</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<div style="padding:10px ">
				<table class="table table-condensed table-striped table-bordered" style="background-color:white;width:70% ">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>Date</th>
						<th>Amount</th>
						<th>Bid</th>
						<th>Action</th>
						<th>User</th>						
					</tr>
				</thead>
				<tbody>
<?php
foreach ($Buydeals as $deal){?>
	<tr>
		<?php if($deal['user_id']==$user['_id']){?>
		<td><a href="/transact/delete/<?=$deal['_id']?>" class="tooltip-x " rel='tooltip' title='Remove this bid'><i class="icon icon-remove"></i></a></td>
		<?php }else{?>
		<td><a href="#myModal" role="button" data-toggle="modal" class="tooltip-x " rel='tooltip' title='Respond to this bid' 
		onClick="respondBid('<?=$deal['user_id']?>','<?=$deal['username']?>','<?=$deal['_id']?>','<?=$deal['btc_amount']?>','<?=$deal['bid_amount']?>','<?=$deal['type']?>','<?=$deal['currency']?>')">
		<i class="icon icon-ok"></i></a></td>
		<?php }?>
		<td><?=$deal['datetime']['date']?> <?=$deal['datetime']['time']?></td>
		<td><?=$deal['btc_amount']?> BTC</td>		
		<td><?=$deal['bid_amount']?> <?=$deal['currency']?></td>				
		<td><?=$deal['type']?> BTC</td>
		<?php if($deal['user_id']==$user['_id']){?>		
		<td><span class="label label-success"><?=$deal['username']?></span> My bid</td>
		<?php }else{?>
		<td><span class="label label-warning"><?=$deal['username']?></span></td>
		<?php }?>
		
	</tr>
<?php	}?>
				</tbody>
				</table>
				</div>
			</div>
			<div class="tab-pane" id="tab2">
				<div style="padding:10px ">
				<table class="table table-condensed table-striped table-bordered" style="background-color:white;width:70% ">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>Date</th>
						<th>Amount</th>
						<th>Bid</th>
						<th>Action</th>
						<th>User</th>						
					</tr>
				</thead>
				<tbody>
<?php
foreach ($Selldeals as $deal){?>
	<tr>
		<?php if($deal['user_id']==$user['_id']){?>
		<td><a href="/transact/delete/<?=$deal['_id']?>" class="tooltip-x " rel='tooltip' title='Remove this bid'><i class="icon icon-remove"></i></a></td>
		<?php }else{?>
		<td><a href="#myModal" role="button" data-toggle="modal" class="tooltip-x " rel='tooltip' title='Respond to this bid' 
		onClick="respondBid('<?=$deal['user_id']?>','<?=$deal['username']?>','<?=$deal['_id']?>','<?=$deal['btc_amount']?>','<?=$deal['bid_amount']?>','<?=$deal['type']?>','<?=$deal['currency']?>')">
		<i class="icon icon-ok"></i></a></td>
		<?php }?>
		<td><?=$deal['datetime']['date']?> <?=$deal['datetime']['time']?></td>
		<td><?=$deal['btc_amount']?> BTC</td>		
		<td><?=$deal['bid_amount']?> <?=$deal['currency']?></td>				
		<td><?=$deal['type']?> BTC</td>
		<?php if($deal['user_id']==$user['_id']){?>		
		<td><span class="label label-success"><?=$deal['username']?></span> My bid</td>
		<?php }else{?>
		<td><span class="label label-warning"><?=$deal['username']?></span></td>
		<?php }?>
	</tr>
<?php	}?>
				</tbody>
				</table>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none ">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="myModalLabel">Respond to this bid</h3>
</div>
<div class="modal-body">
<span id='Username'></span> wants to <span id='Type'></span> <span id="BTC_Amount"></span> BTC at <span id="Bid_Amount"></span> 
<span id="Currency"></span>.<br>
I am willing to <span id="Response"></span> at the same offer and accept 
<span id="CurrencyOut"></span> <span id="TotalAmount"></span>.

<?=$this->form->hidden('datetime.date',array('value'=>gmdate('Y-m-d',time()))); ?>
<?=$this->form->hidden('datetime.time',array('value'=>gmdate('H:i:s',time()))); ?>
<?=$this->form->hidden('user_id',array('value'=>'')); ?>
<?=$this->form->hidden('deal_id',array('value'=>'')); ?>
<?=$this->form->hidden('complete',array('value'=>'N')); ?>


</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary">Save changes</button>
</div>
</div>