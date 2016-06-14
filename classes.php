<?php
class Customers {

	public $customer_header = array();
	public $customer_arr = array();

	public function __construct() {
		
		$customer_file = fopen('csv/customers.csv', 'r') or die("Could not open file");
		$this->customer_header[] = fgetcsv($customer_file);

		// push csv to array
		while (($row = fgetcsv($customer_file))) {
			$this->add($row);
		}
		fclose($customer_file);
	}

	// create array with headers
	public function add($row) {
		$this->customer_arr[] = array_combine($this->customer_header[0], $row);
	}

	// write to csv-file
	public function writecsv() {
		$file = fopen('csv/customers.csv', 'w') or die("Could not open file");

		// write headers
		for($i = 0; $i < count($this->customer_header[0]); $i++) {
			if ($i < (count($this->customer_header[0]) - 1)) {
				fwrite($file, $this->customer_header[0][$i] . ",");
			} else {
				fwrite($file, $this->customer_header[0][$i] . "\r\n");
			}
		}
		
		// write content
		foreach($this->customer_arr as $c) {
			fwrite($file, $c['id'] . ",");
			fwrite($file, $c['firstname'] . ",");
			fwrite($file, $c['surname'] . ",");
			fwrite($file, $c['address'] . ",");
			fwrite($file, $c['birthdate'] . ",");
			fwrite($file, $c['email'] . "\r\n");
		}
		fclose($file);
	}
}

// instance of customer obj.
$customers = new Customers();

class Accounts {

	public $account_header = array();
	public $accounts_arr = array();

	public function __construct() {
		
		$account_file = fopen('csv/accounts.csv', 'r') or die("Could not open file");
		$this->account_header[] = fgetcsv($account_file);

		// looping through the csv file
		while (($row = fgetcsv($account_file))) {
			$this->add($row);
		}
		fclose($account_file);
	}

	// create array with headers
	public function add($row) {
		$this->accounts_arr[] = array_combine($this->account_header[0], $row);
	}

	// write to csv
	public function writecsv() {
		$file = fopen('csv/accounts.csv', 'w') or die("Could not open file");

		// write headers
		for($i = 0; $i < count($this->account_header[0]); $i++) {
			if ($i < (count($this->account_header[0]) - 1)) {
				fwrite($file, $this->account_header[0][$i] . ",");
			} else {
				fwrite($file, $this->account_header[0][$i] . "\r\n");
			}
		}
		
		// write content
		foreach($this->accounts_arr as $a) {
			fwrite($file, $a['id'] . ",");
			fwrite($file, $a['accountnumber'] . ",");
			fwrite($file, $a['currency'] . ",");
			fwrite($file, $a['balance'] . "\r\n");
		}
		fclose($file);
	}
}

// instance of account obj.
$accounts = new Accounts();

class Transactions {

	public $transactions_arr = array();
	public $transaction_header = array();

	public function __construct() {
		
		$transaction_file = fopen('csv/transactions.csv', 'r') or die("Could not open file");
		$this->transaction_header[] = fgetcsv($transaction_file);

		// looping through the csv file
		while (($row = fgetcsv($transaction_file))) {
			if (count($row)) {
				$this->add($row);
			}
		}
		fclose($transaction_file);
	}

	// create array with headers
	public function add($row) {
		$this->transactions_arr[] = array_combine($this->transaction_header[0], $row);
	}

	// write to csv
	public function writecsv() {
		$file = fopen('csv/transactions.csv', 'w') or die("Could not open file");

		// write headers
		for($i = 0; $i < count($this->transaction_header[0]); $i++) {
			if ($i < (count($this->transaction_header[0]) - 1)) {
				fwrite($file, $this->transaction_header[0][$i] . ",");
			} else {
				fwrite($file, $this->transaction_header[0][$i] . "\r\n");
			}
		}

		// write content
		foreach($this->transactions_arr as $t) {
			fwrite($file, $t['transid'] . ",");
			fwrite($file, $t['sum'] . ",");
			fwrite($file, $t['balance'] . ",");
			fwrite($file, $t['currency'] . ",");
			fwrite($file, $t['type'] . ",");
			fwrite($file, $t['accountnumber'] . ",");
			fwrite($file, $t['date'] . ",");
			fwrite($file, $t['description'] . "\r\n");
		}
		fclose($file);
	}
}

// instance of transaction obj.
$transactions = new Transactions();
?>
