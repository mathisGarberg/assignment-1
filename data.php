<?php require_once('new_classes.php'); ?>
<?php require_once('classes.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Upload</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.darkly.css" />
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<h1>Upload</h1>
					<form method="GET">
						<select id="dropdown" name="row">
							<option value="newCustomers">Create new Customers</option>
							<option value="newAccounts">Create new Accounts</option>
							<option value="newTransactions">Create new Transactions</option>
						</select>
						&nbsp;
						<input class="btn-sm btn-primary active" type="Submit" value="Confirm">
					</form>
					<br>
					<?php
					$bError = false;

					if(isset($_GET['row'])) {

						foreach($_GET as $value) {
              
							switch($value) {
								
								case "newCustomers":
								
									?>
									<table class="table table-striped table-bordered">
										<thead>
											<th>Firstname</th>
											<th>Surname</th>
											<th>Adress</th>
											<th>Birthdate</th>
											<th>Email</th>
											<th></th>
										</thead>
										<?php
										foreach($newCustomers->newCustomers_arr as $nC) {
											
											$newC = array('firstname'=>$nC['firstname'], 'surname'=>$nC['surname'], 'address'=>$nC['address'], 'birthdate'=>$nC['birthdate'], 'email'=>$nC['email']);

											echo "<tr>";
											
											// validation code
											if(empty($nC['firstname'])) {
												echo "<td class=\"required\">" . "Firstname can not be empty!" . "</td>";
												$bError = true;
											} else if(!preg_match("/^[a-zA-Z ]*$/",$newC['firstname'])) {
												echo "<td class=\"required\">" . "Only letters and white space allowed" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . $nC['firstname'] . "</td>";
											}
											
											if(empty($nC['surname'])) {
												echo "<td class=\"required\">" . "Surname can not be empty!" . "</td>";
												$bError = true;
											} else if(!preg_match("/^[a-zA-Z ]*$/",$newC['surname'])) {
												echo "<td class=\"required\">" . "Only letters and white space allowed" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . $nC['surname'] . "</td>";
											}
											
											if(empty($nC['address'])){
												echo "<td class=\"required\">" . "Adress can not be empty!" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . $nC['address']. "</td>";
											}

											if(empty($nC['birthdate'])){
												echo "<td class=\"required\">" . "Birthdate can not be empty!" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . $nC['birthdate'] . "</td>";
											}

											if(empty($nC['email'])){
												echo "<td class=\"required\">" . "Email can not be empty!" . "</td>";
												$bError = true;
											} else if(!filter_var($newC['email'], FILTER_VALIDATE_EMAIL)){
												echo "<td class=\"required\">" . "The email isn't valid!" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . $nC['email'] . "</td>";
											}

											foreach($customers->customer_arr as $c){
												if($c['firstname'] == $newC['firstname']){
													if($c['surname'] == $newC['surname']){
														if($c['address'] == $newC['address']){
															if($c['email'] == $newC['email']){
																echo "<td class=\"required\"> Customer already exists! </td>";
																$bError = true;
																break;
															}
														}
													}
												}
											}
											
										}
										?>
										</tr>
									</table>
									<a href="account.php">Go to customers -></a>
									<?php
									break;

								case "newAccounts":
									
									?>
									<table class="table table-striped table-bordered">
										<thead>
											<th>Account No.</th>
											<th>Currency</th>
											<th>Balance</th>
											<th></th>
										</thead>
										<?php
										foreach($newAccounts->newAccounts_arr as $nA){
											
											$newA = array('accountnumber'=>$nA['accountnumber'], 'currency'=>$nA['currency'], 'balance'=>$nA['balance']);

											echo "<tr>";

												if(empty($nA['accountnumber'])){
													echo "<td class=\"required\">" . "Accountnumber can not be empty!" . "</td>";
													$bError = true;
												} else {
													echo "<td>" . $nA['accountnumber'] . "</td>";
												}

												if(empty($nA['currency'])){
													echo "<td class=\"required\">" . "Currency can not be empty!" . "</td>";
													$bError = true;
												} else {
													echo "<td>" . $nA['currency'] . "</td>";
												}

												if(empty($nA['balance'])){
													echo "<td class=\"required\">" . "Currency can not be empty!" . "</td>";
													$bError = true;
												} else {
													echo "<td>" . number_format($nA['balance'], 2, ',', '.') . "</td>";
												}

												foreach($accounts->accounts_arr as $a){
													if($a['accountnumber'] == $newA['accountnumber']){
														if($a['currency'] == $newA['currency']){
															if($a['balance'] == $newA['balance']){
																echo "<td class=\"required\"> Account already exists! </td>";
																$bError = true;
																break;
															}
														}
													}
												}
											echo "</tr>";
											
										}
										?>
									</table>
									<a href="account.php">Go to accounts -></a>
									<?php
									break;

								case "newTransactions":
									
									?>
									<table class="table table-striped table-bordered">
										<thead>
											<th>Sum</th>
											<th>Balance</th>
											<th>Currency</th>
											<th>Type</th>
											<th>Account No.</th>
											<th>Description</th>
											<th></th>
										</thead>
										<?php
										foreach($newTransactions->newTransactions_arr as $nT){
											
											$newT = array('transid'=>$nT['transid'], 'sum'=>$nT['sum'], 'balance'=>$nT['balance'], 'currency'=>$nT['currency'], 'type'=>$nT['type'], 'accountnumber'=>$nT['accountnumber'], 'description'=>$nT['description']);
											
											echo "<tr>";
											
											if(empty($nT['sum'])){
												echo "<td class=\"required\">" . "Sum can not be empty!" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . number_format($nT['sum'], 2, ',', '.') . "</td>";
											}

											if(empty($nT['balance'])){
												echo "<td class=\"required\">" . "Balance can not be empty!" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . number_format($nT['balance'], 2, ',', '.'). "</td>";
											}

											if(empty($nT['currency'])){
												echo "<td class=\"required\">" . "Currency can not be empty!" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . $nT['currency'] . "</td>";
											}

											if(empty($nT['type'])){
												echo "<td class=\"required\">" . "Type can not be empty!" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . $nT['type'] . "</td>";
											}

											if(empty($nT['accountnumber'])){
												echo "<td class=\"required\">" . "Accountnumber can not be empty!" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . $nT['accountnumber'] . "</td>";
											}

											if(empty($nT['description'])){
												echo "<td class=\"required\">" . "Description can not be empty!" . "</td>";
												$bError = true;
											} else {
												echo "<td>" . $nT['description'] . "</td>";
											}

											foreach($transactions->transactions_arr as $t){
												if($t['transid'] == $newT['transid']){
													if($t['sum'] == $newT['sum']){
														if($t['balance'] == $newT['balance']){
															if($t['currency'] == $newT['currency']){
																if($t['type'] == $newT['type']){
																	if($t['accountnumber'] == $newT['accountnumber']){
																		if($t['description'] == $newT['description']){
																			echo "<td class=\"required\"> Transaction already exists! </td>";
																			$bError = true;
																			break;
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
										?>
										</tr>
									</table>
									<a href="account.php">Go to accounts -></a>
									<?php
									break;
							}		
						}
					}

					// add new customer/account/transaction if no errors are provided
					if($bError != true) {
						
						if(isset($_GET['row'])) {

							foreach($_GET as $value) {
								
								switch($value) {
									
									case "newCustomers":
										
										foreach($newCustomers->newCustomers_arr as $nC){
											$row = array();

											$row[] = uniqid();
											$row[] = $nC['firstname'];
											$row[] = $nC['surname'];
											$row[] = $nC['address'];
											$row[] = strtotime($nC['birthdate']);
											$row[] = $nC['email'];

											$customers->add($row);
											$customers->writecsv();
										}
										
										echo "New customers uploaded successfully!";
										break;

									case "newAccounts":
										
										foreach($newAccounts->newAccounts_arr as $nA){

											$row = array();

											$row[] = $nA['id'];
											$row[] = $nA['accountnumber'];
											$row[] = $nA['currency'];
											$row[] = $nA['balance'];

											$accounts->add($row);
											$accounts->writecsv();
										}
										
										echo "New account uploaded successfully!";
										break;

									case "newTransactions":

										foreach($newTransactions->newTransactions_arr as $nT){
											$row = array();

											$row[] = $nT['transid'];
											$row[] = $nT['sum'];
											$row[] = $nT['balance'];
											$row[] = $nT['currency'];
											$row[] = $nT['type'];
											$row[] = $nT['accountnumber'];
											$row[] = strtotime(date("d.m.Y"));
											$row[] = $nT['description'];

											$transactions->add($row);
											$transactions->writecsv();
										}
										
										echo "New transaction uploaded successfully!";
										break;
								}
							}
						}
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>
