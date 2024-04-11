<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Controller\Common;

use Application\Controller\Common\Traits\AssetsAwareTrait;
use Application\Controller\Common\Traits\TwigAwareTrait;
use Eureka\Component\Web\Menu\MenuControllerAwareTrait;
use Eureka\Component\Web\Meta\MetaControllerAwareTrait;
use Eureka\Component\Web\Session\SessionAwareTrait;
use Eureka\Kernel\Http\Controller\Controller;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractWebController extends Controller
{
    use AssetsAwareTrait;
    use MenuControllerAwareTrait;
    use MetaControllerAwareTrait;
    use SessionAwareTrait;
    use TwigAwareTrait;

    /**
     * @throws \JsonException
     */
    public function preAction(?ServerRequestInterface $serverRequest = null): void
    {
        if ($serverRequest === null) {
            throw new \UnexpectedValueException();
        }

        parent::preAction($serverRequest);

        $this->initializeAssets();

        $currentUri      = $serverRequest->getUri();
        $currentUriImage = $currentUri
            ->withPath('')
            ->withFragment('')
            ->withQuery('')
        ;

        $this->getContext()
            ->add('menu', $this->getMenu())
            ->add('meta', $this->getMeta())
            ->add('theme', $this->getTheme($serverRequest))
            ->add('cssFiles', $this->getCssFiles())
            ->add('jsFiles', $this->getJsFiles())
            ->add('flashNotifications', $this->getAllFlashNotification())
            ->add('flashFormErrors', $this->getFormErrors())
            ->add('currentUrl', (string) $currentUri)
            ->add('baseUrlImage', (string) $currentUriImage)
        ;

        $this->getSession()?->clearFlash();
    }

    private function getTheme(?ServerRequestInterface $serverRequest = null): string
    {
        return $serverRequest?->getCookieParams()['theme'] ?? 'auto';
    }
}
