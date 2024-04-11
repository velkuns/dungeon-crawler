<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Service\Twig;

use Symfony\Component\Routing\Router;
use Twig;
use Twig\Error\LoaderError;

class TwigConfigurator
{
    /**
     * @phpstan-param array<string, string> $twigPaths
     * @throws LoaderError
     */
    public function __construct(
        private readonly Twig\Environment $twig,
        private readonly array $twigPaths,
        Router $router,
        string $webAssetsPath
    ) {
        $this->configurePaths($twigPaths);
        $this->configureHelper($router, $webAssetsPath);
        $this->configureExtensions();
    }

    /**
     * @return array<string, string>
     */
    public function getPaths(): array
    {
        return $this->twigPaths;
    }

    /**
     * @param array<string, callable> $functions
     */
    public function configureFunctions(array $functions): void
    {
        //~ Add functions to main twig instance
        foreach ($functions as $name => $callback) {
            $this->twig->addFunction(new Twig\TwigFunction($name, $callback));
        }
    }

    /**
     * @param array<string, string> $paths
     * @return void
     * @throws LoaderError
     */
    private function configurePaths(array $paths): void
    {
        //~ Add path
        $loader = $this->twig->getLoader();
        if ($loader instanceof Twig\Loader\FilesystemLoader) {
            foreach ($paths as $namespace => $path) {
                $loader->addPath($path, $namespace);
            }
        }
    }

    private function configureHelper(Router $router, string $webAssetsPath): void
    {
        //~ Add functions to main twig instance
        $helper = new TwigHelper($router, $webAssetsPath);
        $this->configureFunctions($helper->getCallbackFunctions());
    }

    private function configureExtensions(): void
    {
        //~ Nothing for now
    }
}
