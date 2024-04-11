<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Controller\Web\Page;

use Application\Controller\Common\AbstractWebController;
use Eureka\Kernel\Http\Exception\HttpNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class PageController
 *
 * @author Romain Cottard
 */
class PageController extends AbstractWebController
{
    private const ALLOWED_PAGES = [
        'buttons',
        'dropdowns',
        'typography',
        'form',
        'tables',
        'charts',
        'icons',
        'blank',
        '404',
        '500',
        'login',
        'register',
    ];

    /**
     * @param ServerRequestInterface $serverRequest
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $serverRequest): ResponseInterface
    {
        $page = $serverRequest->getAttribute('page');

        if (!in_array($page, self::ALLOWED_PAGES)) {
            throw new HttpNotFoundException('Page not found', 404);
        }

        return $this->getResponse($this->render('@app/Page/' . $page . '.twig'));
    }
}
