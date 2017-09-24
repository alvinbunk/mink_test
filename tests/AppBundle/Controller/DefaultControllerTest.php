<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	public function testIndex()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/');

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }
    
	public function testLogin()
	{
		$client = static::createClient();
		$client->followRedirects();	// After authenticating will redirect.
		
		$crawler = $client->request('GET', '/login');
		$form = $crawler->selectButton('login')->form();
		
		// Set user values.
		$form['_username'] = 'admin';
		$form['_password'] = 'admin123';
		
		$crawler = $client->submit($form);	// Submit form

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
		
		$link = $crawler->selectLink('Visit secure page')->link();
		$crawler = $client->click($link);
		
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertContains('Welcome Username: admin', $client->getResponse()->getContent());
	}
	
	public function testInsecure()
	{
		$client = static::createClient();
		
		$crawler = $client->request('GET', '/');
		
		$link = $crawler->selectLink('Visit insecure page')->link();
		$crawler = $client->click($link);
		
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertContains('This is a insecure page.', $client->getResponse()->getContent());
	}
	
	public function testSecure()
	{
		$client = static::createClient();
		$client->followRedirects();	// After authenticating will redirect.
		
		$crawler = $client->request('GET', '/');
		$link = $crawler->selectLink('Visit secure page')->link();
		$crawler = $client->click($link);
		$form = $crawler->selectButton('login')->form();
		
		// Set user values.
		$form['_username'] = 'mink';
		$form['_password'] = 'mink123';
		
		$crawler = $client->submit($form);	// Submit form

		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertContains('Welcome Username: mink', $client->getResponse()->getContent());
		
		$crawler = $client->request('GET', '/');
		$link = $crawler->selectLink('Test Logout')->link();
		$crawler = $client->click($link);
	}
	
	public function testAjax()
	{
		$client = static::createClient();
		
		$client->request('GET', '/ajax?item=City');
		
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertContains('default',
				$client->getResponse()->getContent());
		
		$client->request('GET', '/ajax');
		
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertContains('default',
				$client->getResponse()->getContent());
	}
}
