<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Controller\Web\Home;

use Application\Controller\Common\AbstractWebController;
use Psr\Http\Message\ResponseInterface;

/**
 * Class HomeController
 *
 * @author Romain Cottard
 */
class HomeController extends AbstractWebController
{
    /**
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return $this->getResponse($this->render('@app/Home/Home.twig'));
    }
}
