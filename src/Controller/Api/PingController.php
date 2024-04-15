<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Controller\Api;

use Application\Controller\Common\AbstractApiController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PingController extends AbstractApiController
{
    /**
     * @param ServerRequestInterface $serverRequest
     * @return ResponseInterface
     */
    public function ping(ServerRequestInterface $serverRequest): ResponseInterface
    {
        return $this->getResponseJson(['data' => 'pong']);
    }
}
