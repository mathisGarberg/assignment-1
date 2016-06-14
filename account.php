<?php require_once('classes.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Accounts</title>
		<meta charset="iso-8859-1" />
		<link rel="stylesheet" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-2">
					<h1>Account Overview</h1>
					<form method="GET">
						<select id="dropdown" name="account">
						<?php
						foreach($accounts->accounts_arr as $a) {
							$owner;
							
							foreach($customers->customer_arr as $c) {
								// find owner and associated accounts
								if($a['id'] === $c['id']) {
									$owner = $c;
									// break out if owner is found
									break;
								}
							}
							
							echo "<option value=\"" . $a['accountnumber'] . "\"";
							
							// set the selected account
							if(isset($_GET['account'])) {
								if($_GET['account'] == $a['accountnumber']) {
									echo "selected=\"selected\"";
								}
							}
							echo ">" . $a['accountnumber']. " - ".$owner['firstname']. " ". $owner['surname']. "</option>";
						}
						?>
						</select>
						&nbsp;
						<input class="btn-sm btn-primary active" type="Submit" value="Select Account">
					</form>
					<br>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4 col-lg-offset-2">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<td>AVALIABLE</td>
								<td>Deposits</td>
								<td>Withdrawals</td>
							</thead>
							<tr>
							<?php
							if(isset($_GET['account'])) {
								
								$account = $_GET['account'];
								$deposits = 0;
								$withdrawals = 0;

								// number of deposits and withdrawals for each account
								foreach ($transactions->transactions_arr as $t) {
									if($account === $t['accountnumber']) {
										if($t['sum'] > 0) {
											$deposits++;
										} else {
											$withdrawals++;
										}
									}
								}
								
								// calculate new balance
								$balance = $t['balance'];
								foreach($transactions->transactions_arr as $t){
									if($account === $t['accountnumber']) {
										$balance += intval($t['sum']);
									}
								}
								
								echo "<td>" . number_format($balance, 2, ',', '.'). " " . $t['currency'] . "</td>";
								echo "<td>" . $deposits . "</td>";
								echo "<td>" . $withdrawals . "</td>";
							  
							}
							?>
							</tr>
						</table>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<h2>Transaction History</h2>	
					<div class="table-responsive">
						<table class="table">
							<thead>
								<td>Transaction Date <a href="account.php?account=<?php if(isset($_GET['account'])) { echo $_GET['account']; } ?>&sort=date"><i class="fa fa-fw fa-sort"></i></a></td>
								<td>Type</td>
								<td>Description</td>
								<td>Amount <a href="account.php?account=<?php if(isset($_GET['account'])) { echo $_GET['account']; } ?>&sort=amount"><i class="fa fa-fw fa-sort"></i></a></td>
								<td>Currency</td>
								<td>Balance</td>
							</thead>
							<?php
							if(isset($_GET['account'])) {
								
								$account = $_GET['account'];
									
								if(isset($_GET['sort'])){
									
									$sort = $_GET['sort'];
									
									switch($sort){
										// table sorted by amount
										case 'amount':
										
											$sortArray = array();

											foreach($transactions->transactions_arr as $t){
												foreach ($t as $key => $value){
													if(!isset($sortArray[$key])){
														$sortArray[$key] = array();
													}
												$sortArray[$key][] = $value;
												}
											}

											$orderby = "sum";
											array_multisort($sortArray[$orderby],SORT_DESC,$transactions->transactions_arr);
											
											foreach($transactions->transactions_arr as $t){
												if($account == $t['accountnumber']) {
													echo "<tr>";
														echo "<td>" . date('d.m.Y', $t['date']) . "</td>";
														echo "<td>" .$t['type']. "</td>";
														echo "<td>" . $t['description'] . "</td>";
														if($t['sum'] > 0) {
															echo "<td class=\"deposits\">" .number_format($t['sum'], 2, ',', '.'). "</td>";
														} else {
															echo "<td class=\"withdrawals\">". number_format($t['sum'], 2, ',', '.'). "</td>";
														}
														echo "<td>" .$t['currency']. "</td>";
														echo "<td>" . number_format($t['balance'], 2, ',', '.') . "</td>";
													echo "</tr>";
												}
											}

											break;
									
										// table sorted by date
										case 'date':
										
											$sortArray = array();

											foreach($transactions->transactions_arr as $t){
												foreach ($t as $key => $value){
													if(!isset($sortArray[$key])){
														$sortArray[$key] = array();
													}
												$sortArray[$key][] = $value;
												}
											}

											$orderby = "date";

											array_multisort($sortArray[$orderby],SORT_DESC,$transactions->transactions_arr);

											foreach($transactions->transactions_arr as $t){
												if($account === $t['accountnumber']) {
													echo "<tr>";
														echo "<td>" . date('d.m.Y ', $t['date']) . "</td>";
														echo "<td>" .$t['type']. "</td>";
														echo "<td>" . $t['description'] . "</td>";
														if($t['sum'] > 0) {
															echo "<td class=\"deposits\">" .number_format($t['sum'], 2, ',', '.'). "</td>";
														} else {
															echo "<td class=\"withdrawals\">". number_format($t['sum'], 2, ',', '.'). "</td>";
														}
														echo "<td>" .$t['currency']. "</td>";
														echo "<td>" . number_format($t['balance'], 2, ',', '.') . "</td>";
													echo "</tr>";
												}
											}

											break;
									}
								} else {
									foreach ($transactions->transactions_arr as $t) {
										if($account == $t['accountnumber']) {
											echo "<tr>";
												echo "<td>" . date('d.m.Y ', $t['date']) . "</td>";
												echo "<td>" . $t['type'] . "</td>";
												echo "<td>" . $t['description'] . "</td>";
												if($t['sum'] > 0) {
													echo "<td class=\"deposits\">" . number_format($t['sum'], 2, ',', '.') . "</td>";
												} else {
													echo "<td class=\"withdrawals\">". number_format($t['sum'], 2, ',', '.') . "</td>";
												}
												echo "<td>" . $t['currency']. "</td>";
												echo "<td>" . number_format($t['balance'], 2, ',', '.') . "</td>";
											echo "</tr>";
										}
									}	
								}
							}
						?>
						</table>
					</div>
					<table>
						<tr>
							<td><a href="data.php">Create new accounts or transactions -></a></td>
						</tr>
						<tr>
							<td><a href="customers.php">Go back to customers -></a></td>
						</tr>
					</table>
				</div>
			</div>
		
	</body>
</html>
