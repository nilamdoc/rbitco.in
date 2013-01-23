<h4>Buy BTC:</h4>
<?=$wallet['wallet']['balance']?> (<?= ucwords($word)?>)
<div style="background-color:#fff;padding-top:10px;border-top:1px solid;border-bottom:1px solid  ">
	<div class="tabbable"> <!-- Only required for left/right tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">INR</a></li>
			<li><a href="#tab2" data-toggle="tab">USD</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<p>Buy by paying INR</p>
			</div>
			<div class="tab-pane" id="tab2">
				<p>Buy by paying USD</p>
			</div>
		</div>
	</div>
</div>