<?php
// tests/AppBundle/Functional/MinkTest.php
 
namespace Tests\AppBundle\Functional;
 
use PHPUnit\Framework\TestCase;
 
class MinkTest extends TestCase
{
	use MinkSetup;
    
	public function testHomePage(){
    	$this->visit('/'); // Go to homepage.
    	$content = $this->getCurrentPageContent();   // Get page content.
    	$this->assertContains('Test Login', $content);
    	$this->assertContains('Visit insecure page', $content);
    	$this->assertContains('Visit secure page', $content);
    	$this->assertContains('Test Logout', $content);
    	$this->stop();	// Stop tests.
	}
	
	/**
	 * @depends testHomePage
	 */
	public function testClickLogin(){
		$this->visit('/'); // Go to homepage.
		$page = $this->getCurrentPage(); // Get the Login Link.
		$link = $page->findLink('Test Login');
		$link->click();
		$page = $this->getCurrentPage(); // Get the page.
		$page->fillField('username', 'mink'); // Enter username.
		$page->fillField('password', 'mink123'); // Enter password.
		$page->pressButton('login');    // Click 'login' button.
		$content = $this->getCurrentPageContent(); // Get the page content.
		$this->assertContains('<h1><span>Welcome to</span> Symfony', $content);
		$this->stop();	// Stop tests.
	}
	
	/**
	 * @depends testClickLogin
	 */
	public function testClickLogout(){
		$this->visit('/'); // Go to homepage.
		$page = $this->getCurrentPage(); // Get the Login Link.
		$link = $page->findLink('Test Logout');
		$link->click();
		$content = $this->getCurrentPageContent(); // Get the page content.
		$this->assertContains('<h1><span>Welcome to</span> Symfony', $content);
		$this->stop();	// Stop tests.
	}
	
	/**
	 * @depends testClickLogout
	 */
	public function testSecurePage(){
		$this->login('mink', 'mink123'); // Login first.
 
		$this->visit('/secure'); // Go to secure page.
		$content = $this->getCurrentPageContent();   // Get page content.
		$this->assertContains('This is a secure page', $content);
      $this->assertContains('Welcome Username: mink', $content);
        
		// Logout.
		$page = $this->getCurrentPage(); // Get the page.
		$link = $page->findLink('Test Logout');
		$link->click();
        
		// Should be at homepage again.
		$content = $this->getCurrentPageContent();   // Get page content.
		$this->assertContains('Visit secure page', $content);
        
		// Login admin.
		$this->login('admin', 'admin123');
		$this->visit('/secure'); // Go to secure page.
		$content = $this->getCurrentPageContent();   // Get page content.
		$this->assertContains('Welcome Username: admin', $content);
        
		$this->stop();	// Stop tests.
	}
	
	public function testAjax(){
		$this->visit('/insecure'); // Go to insecure page.
		$content = $this->getCurrentPageContent();   // Get page content.
		$this->assertContains('This is a insecure page', $content);
		
		$page = $this->getCurrentPage(); // Get the page.
		$dropdown = $page->findById('ajax');
		$dropdown->selectOption('City',false);
		
		$this->getSession()->wait(5000,"$('#txtHint').text() == 'Taft'");
		
		$content = $this->getCurrentPageContent();   // Get page content.
		$this->assertContains('Taft', $content);
		
		$this->stop();	// Stop tests.
	}
}