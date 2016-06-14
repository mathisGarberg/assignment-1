<!DOCTYPE html>
<?php require_once('classes.php'); ?>
<html>
	<head>
		<title>Customers</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.darkly.css" />
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-2">
					<h1>Customer Overview</h1>
					<br>
					<table class="table">
						<thead>
							<td>Total Customers</td>
							<td>Total Accounts</td>
						</thead>
						<tr>
							<td><?php echo count($customers->customer_arr); ?></td>
							<td><?php echo count($accounts->accounts_arr); ?></td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Customers<h4>
						</div>
						<table class="table table-striped table-bordered">
						<?php
						$getId;
						$bShowAccountsHeader = false;

						foreach($customers->customer_arr as $c) {
							$total = 0;
							$numA = 0;
							global $bShowDetailsHeader;
							
							// calculate number of accounts and total assets for each customer
							foreach($accounts->accounts_arr as $a) {
								if($c['id'] === $a['id']) {
									$total += floatval(str_replace(' ', '', $a['balance']));
									$numA++;
								}
							}

							// display header
							if(!$bShowAccountsHeader) {
						?>
							<thead>
								<th>Owner</th>
								<th>Birthdate</th>
								<th>Address</th>
								<th>Total</th>
								<th>Num. Accounts</th>
								<th></th>
							</thead>
							<?php
							$bShowAccountsHeader = true;
							}
							?>
							<!-- loop through and display customer information-->
							<tr>
								<td><?php echo $c['firstname']. " " .$c['surname']; ?></td>
								<td><?php echo date('d.m.Y', $c['birthdate']); ?></td>
								<td><?php echo $c['address']; ?></td>
								<td><b><?php echo number_format($total, 2, ',', '.'); ?></b></td>
								<td><?php echo $numA; ?></td>
								<td><a id="btn" href="customers.php?id=<?php echo $c['id']; ?>"><input class="btn-sm btn-primary" type="button" value="Show Details"></a></td>
							</tr>
							<?php
							// show account details when user press button
							foreach($accounts->accounts_arr as $a) {
								if ($c['id'] === $a['id']) {
									if(isset($_GET['id'])) {
										$getId = $_GET['id'];
										if($getId === $a['id']) {
											if (!$bShowDetailsHeader) {
							?>
												<thead>
													<th>Account No.</th>
													<th>Balance</th>
													<th colspan="5"></th>
												</thead>
							<?php
													$bShowDetailsHeader = true;
													$bShowAccountsHeader = false;
												}
											echo "<tr>";
												echo "<td>" . "<a href=\"account.php?account=" .$a['accountnumber'].  "\">" .$a['accountnumber']. "</a>" . "</td>";
												echo "<td>" . number_format($a['balance'], 2, ',', '.') . "</td>";
												echo "<td colspan=\"4\"></td>";
											echo "</tr>";
											}
										}
									}
								}
							}
							?>
						</table>
					</div>
					
					<table>
						<tr>
							<td><a href="data.php">Create new customers -></a></td>
						</tr>
						<tr>
							<td><a href="account.php">Go to accounts -></a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
