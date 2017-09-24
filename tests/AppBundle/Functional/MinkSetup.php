<?php
// tests/AppBundle/Functional/MinkSetup.php
 
namespace Tests\AppBundle\Functional;
 
trait MinkSetup
{
	private $minkBaseUrl;
	private $minkSession;
 
	/**
	 * @before
    */
	public function setupMinkSession()
	{
		$this->minkBaseUrl = 'http://mink_test/app_dev.php';
		//$this->minkBaseUrl = 'http://192.168.0.2'
 
		$driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
		$this->minkSession = new \Behat\Mink\Session($driver);
		$this->minkSession->start();
	}
 
	public function getCurrentPage()
	{ return $this->minkSession->getPage(); }
	
	public function getSession()
	{ return $this->minkSession; }
 
	public function getCurrentPageContent()
	{ return $this->getCurrentPage()->getContent(); }
 
	public function visit($url)
	{ $this->minkSession->visit($this->minkBaseUrl . $url); }
 
	public function login($user, $pass){
		$this->minkSession->visit($this->minkBaseUrl . '/login');  // Login link.
		$page = $this->getCurrentPage();
 
		$page->fillField('username', $user); // Enter username.
		$page->fillField('password', $pass); // Enter password.
		$page->pressButton('login');    // Click 'login' button.
	}
 
	/**
    * @afterClass
    */
	public function stop(){
		$this->minkSession->stop();
	}
}