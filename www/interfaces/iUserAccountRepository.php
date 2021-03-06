<?php

// This is the interface used to save, retrieve and update 
// user account data from some persistence medium.
interface iUserAccountRepository {
	// Adds the user with the specified data to the system.
	// Note that a UniqueViolationException can be thrown if 
	// the account being added is not unique. This method 
	// returns the registration token that is needed to 
	// actvate the member account.
	public function add($name, $email, $password);
}

?>