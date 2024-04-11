<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Controller\Web\Error;

use Application\Controller\Common\AbstractWebController;
use Eureka\Component\Web\Notification\NotificationType;
use Eureka\Kernel\Http\Controller\ErrorControllerInterface;
use Eureka\Kernel\Http\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * Class ErrorController
 *
 * @author Romain Cottard
 */
class ErrorController extends AbstractWebController implements ErrorControllerInterface
{
    /**
     * @param ServerRequestInterface $serverRequest
     * @param \Exception $exception
     * @return ResponseInterface
     */
    public function error(ServerRequestInterface $serverRequest, \Exception $exception): ResponseInterface
    {
        //~ Handle authentication errors & redirect to user login page
        if ($exception->getCode() >= 1050 && $exception->getCode() <= 1054 || $exception->getCode() >= 1060) {
            $this->addFlashNotification($exception->getMessage(), NotificationType::Error);
            $this->redirect($this->getRouteUri('user_login'));
        }

        $httpCode = match (true) {
            $exception instanceof Exception\HttpBadRequestException => 400,
            $exception instanceof Exception\HttpUnauthorizedException => 401,
            $exception instanceof Exception\HttpForbiddenException => 403,
            $exception instanceof RouteNotFoundException, $exception instanceof Exception\HttpNotFoundException => 404,
            $exception instanceof Exception\HttpMethodNotAllowedException => 405,
            $exception instanceof Exception\HttpConflictException => 409,
            $exception instanceof Exception\HttpTooManyRequestsException => 429,
            $exception instanceof Exception\HttpServiceUnavailableException => 503,
            default => 500,
        };

        $template = $httpCode < 500 ? 'Error4XX.twig' : 'Error5XX.twig';

        $this->getContext()
            ->add('httpCode', $httpCode)
            ->add('exception', $exception)
        ;

        return $this->getResponse($this->render('@common/Error/' . $template), $httpCode);
    }
}
