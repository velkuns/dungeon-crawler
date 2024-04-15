<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Controller\Common;

use Eureka\Component\Web\Session\SessionAwareTrait;
use Eureka\Kernel\Http\Controller\Controller;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractApiController extends Controller
{
    use SessionAwareTrait;

    public function preAction(?ServerRequestInterface $serverRequest = null): void
    {
        if ($serverRequest === null) {
            throw new \UnexpectedValueException();
        }

        parent::preAction($serverRequest);
    }
}
