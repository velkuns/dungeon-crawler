<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Controller\Common\Traits;

use Eureka\Kernel\Http\Service\DataCollection;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

trait TwigAwareTrait
{
    private Environment $twig;
    protected ?DataCollection $context = null;

    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    protected function getContext(): DataCollection
    {
        if ($this->context === null) {
            $this->context = new DataCollection();
        }

        return $this->context;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function render(string $name): string
    {
        $template = $this->twig->load($name);

        return $template->render($this->getContext()->toArray());
    }
}
