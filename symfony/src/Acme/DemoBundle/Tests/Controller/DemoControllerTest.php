<?php

namespace Acme\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DemoControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/demo/hello/Fabien');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Hello Fabien")')->count());
    }

    public function testSecureSection()
    {
        $client = static::createClient();

        // goes to the secure page
        $crawler = $client->request('GET', '/demo/secured/hello/World');

        // redirects to the login page
        $crawler = $client->followRedirect();

        // submits the login form
        $form = $crawler->selectButton('Login')->form(array('_username' => 'admin', '_password' => 'adminpass'));
        $client->submit($form);

        // redirect to the original page (but now authenticated)
        $crawler = $client->followRedirect();

        // check that the page is the right one
        $this->assertCount(1, $crawler->filter('h1.title:contains("Hello World!")'));

        // click on the secure link
        $link = $crawler->selectLink('Hello resource secured')->link();
        $crawler = $client->click($link);

        // check that the page is the right one
        $this->assertCount(1, $crawler->filter('h1.title:contains("secured for Admins only!")'));
    }


    public function testSecureSectionUsingHttp()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'adminpass',
            ));

        $crawler = $client->request('GET', '/demo/secured/hello/World');

        $this->assertCount(1, $crawler->filter('h1.title:contains("Hello World!")'));
    }


    public function testServiceMocking()
    {
        $twitter = $this->getMock('Acme\DemoBundle\Domain\Twitter', array('tweet'));
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'adminpass',
            ));
        $theTweetText = 'This is the text to be tweeted';
        $container = $client->getKernel()->getContainer();
        $container->set('twitter', $twitter);

        $twitter->expects($this->once())
            ->method('tweet')
            ->with($theTweetText);

        $client->request('GET', '/demo/secured/tweet', array('content' => $theTweetText));
    }


    public function testServiceStubbing()
    {
        $filmsApi = $this->getMock('Acme\DemoBundle\Domain\FilmsApi', array('getFilms'));
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'adminpass',
            ));
        $container = $client->getKernel()->getContainer();
        $container->set('films_api', $filmsApi);
        $filmsApi->expects($this->any())
            ->method('getFilms')
            ->will($this->returnValue(array('Lo que el viento se llevó', 'Con la muerte en los talones')));

        $crawler = $client->request('GET', '/demo/secured/films');

        $this->assertCount(1, $crawler->filter('html:contains("Lo que el viento se llevó")'));
        $this->assertCount(1, $crawler->filter('html:contains("Con la muerte en los talones")'));
    }
}
