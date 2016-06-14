<?php
class newCustomers {

	public $newCustomers_arr = array();
	public $newCustomers_header = array();

	public function __construct() {
		
		$newCustomers_file = fopen('csv/newCustomers.csv', 'r') or die("Could not open file");
		$this->newCustomers_header[] = fgetcsv($newCustomers_file);

		// push csv to array
		while (($row = fgetcsv($newCustomers_file))) {
			$this->add($row);
		}
		fclose($newCustomers_file);
	}

	// create array with headers
	public function add($row) {
		$this->newCustomers_arr[] = array_combine($this->newCustomers_header[0], $row);
	}
}

// instance of newCustomer obj.
$newCustomers = new newCustomers();

class newAccounts {

	public $newAccounts_arr = array();
	public $newAccounts_header = array();

	public function __construct() {
		
		$newAccounts_file = fopen('csv/newAccounts.csv', 'r') or die("Could not open file");
		$this->newAccounts_header[] = fgetcsv($newAccounts_file);

		// push csv to array
		while (($row = fgetcsv($newAccounts_file))) {
			$this->add($row);
		}
		fclose($newAccounts_file);
	} 

	public function add($row) {
		$this->newAccounts_arr[] = array_combine($this->newAccounts_header[0], $row);
	}
}

// instance of newAccount obj.
$newAccounts = new newAccounts();

class newTransactions {

	public $newTransactions_arr = array();
	public $newTransactions_header = array();

	public function __construct() {
		
		$newTransactions_file = fopen('csv/newTransactions.csv', 'r') or die("Could not open file");
		$this->newTransactions_header[] = fgetcsv($newTransactions_file);

		// looping through the csv file
		while (($row = fgetcsv($newTransactions_file))) {
			$this->add($row);
		}
    
		fclose($newTransactions_file);
	}

	public function add($row) {
		$this->newTransactions_arr[] = array_combine($this->newTransactions_header[0], $row);
	}
}

// instance of newTransactions obj.
$newTransactions = new newTransactions();
?>