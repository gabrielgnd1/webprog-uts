<?php
	// Set the cookie expiration time to the past
	setcookie('cookieName', '', time() - 3600, '/');

	// Destroy the session
	session_start();
	session_destroy();
?>
