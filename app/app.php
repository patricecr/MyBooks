<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../views'));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Register services.
$app['dao.author'] = $app->share(function ($app) {
    return new MyBooks\DAO\AuthorDAO($app['db']);
});
$app['dao.book'] = $app->share(function ($app) {
    $bookDAO = new MyBooks\DAO\BookDAO($app['db']);
    $bookDAO->setAuthorDAO($app['dao.author']);
    return $bookDAO;
});