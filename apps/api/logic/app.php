<?php
/**
 * FABIO CICERCHIA - WEBSITE
 *
 * PHP Version 5.4
 *
 * @category  Api
 * @package   Api
 * @author    Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright 2012 Fabio Cicerchia. All Rights reserved.
 * @license   TBD <http://www.fabiocicerchia.it>
 * @link      http://www.fabiocicerchia.it
 */

// -----------------------------------------------------------------------------
// INIT SILEX & SETUP SOME STUFF -----------------------------------------------
// -----------------------------------------------------------------------------
require_once __DIR__ . '/../silex.phar';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

require __DIR__ . '/bootstrap.php';

use FabioCicerchia\Api\Service\EntryPoint;
use FabioCicerchia\Api\Service\Strategy;

// -----------------------------------------------------------------------------
// ERROR HANDLING --------------------------------------------------------------
// -----------------------------------------------------------------------------

/**
 * Error - Closure.
 *
 * @param Exception $e    The Exception instance.
 * @param integer   $code The exception code.
 *
 * @return Response
 */
$error = function (\Exception $e, $code) use ($app)
{
    if ($app['debug']) {
        return;
    }

    $response = new Response($e->getMessage(), $code);

    return $response;
};
$app->error($error);

// -----------------------------------------------------------------------------
// ROUTE ROOT ------------------------------------------------------------------
// -----------------------------------------------------------------------------

/**
 * Root - Closure.
 *
 * @param Silex\Application $app The Silex Application instance.
 *
 * @return Response
 */
$root = function() use($app)
{
    $entryPoint  = new EntryPoint();
    $services    = $entryPoint->getServices();
    $md5_mapping = array_map('md5', $services);
    $routes      = array_combine($md5_mapping, $services);

    $mime_type = 'application/vnd.ads+xml;v=1.0';
    if ($app['debug'] === true) {
        $mime_type = 'application/xml';
    }

    $data    = [
        'routes'    => $routes,
        'mime_type' => $mime_type,
        'api_name'  => 'entry point'
    ];
    $content = $app['twig']->render('root.twig', $data);

    $response = new Response($content);
    $response->headers->set('Content-Type', $data['mime_type']);

    return $response;
};
$app->get('/', $root)->method('GET')->bind('root');

// -----------------------------------------------------------------------------
// ROUTE API -------------------------------------------------------------------
// -----------------------------------------------------------------------------

/**
 * API - Closure.
 *
 * @param string            $api_name The API name retrieved from URL.
 * @param Silex\Application $app      The Silex Application instance.
 *
 * @return Response
 */
$api = function($api_name) use($app)
{
    $database = $app['mongodb']->selectDatabase('curriculum');

    try {
        $service = new Strategy($api_name, $database);
    } catch (UnexpectedValueException $e) {
        $app->abort(404, 'The API ' . $api_name. ' does not exist.');
    }

    $data = $service->getData();
    $data['api_name'] = $api_name;
    $data['current_lang'] = 'en_GB'; // TODO: MODIFY THIS

    $content = $app['twig']->render($api_name . '.twig', $data);

    $mime_type = 'application/vnd.ads+xml;v=1.0';
    if ($app['debug'] === true) {
        $mime_type = 'application/xml';
    }

    $response = new Response($content);
    $response->headers->set('Content-Type', $mime_type);

    return $response;
};

$app->get('/{api_name}', $api)->assert('api_name', '[a-z]+')
    ->method('GET')->bind('api');

// -----------------------------------------------------------------------------
// ROUTE API DEFINITION SYNTAX -------------------------------------------------
// -----------------------------------------------------------------------------

/**
 * API Definition Syntax - Closure.
 *
 * @param Silex\Application $app The Silex Application instance.
 *
 * @return Response
 */
$api_definition_syntax = function() use($app) {
    $content = $app['twig']->render('api-definition-syntax.twig');
    $response = new Response($content);
    $response->headers->set('Content-Type', 'text/plain');

    return $response;
};
$app->get('/api-definition-syntax', $api_definition_syntax)
    ->method('GET')->bind('api_definition_syntax');

// -----------------------------------------------------------------------------
// RETURN APP ------------------------------------------------------------------
// -----------------------------------------------------------------------------
return $app;
