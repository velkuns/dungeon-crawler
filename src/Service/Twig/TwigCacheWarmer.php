<?php

/*
 * Copyright (c) Deezer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Service\Twig;

use Symfony\Component\Finder\Finder;
use Twig;

class TwigCacheWarmer
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        private readonly TwigConfigurator $twigConfigurator,
        private readonly Twig\Environment $twig,
    ) {}

    /**
     * @codeCoverageIgnore
     */
    public function warmUp(): void
    {
        foreach ($this->twigConfigurator->getPaths() as $name => $path) {
            foreach ($this->findTemplatesInDirectory($path) as $template) {
                try {
                    $this->twig->load('@' . $name . '/' . $template);
                } catch (\Exception $e) {
                    // problem during compilation, give up
                    // might be a syntax error or a non-Twig template
                    echo "@$name/$template : {$e->getMessage()}\n";
                }
            }
        }
    }

    /**
     * Find templates in the given directory.
     *
     * @param string $dir The directory where to look for templates
     * @param string|null $namespace The template namespace
     * @return string[]
     * @codeCoverageIgnore
     */
    private function findTemplatesInDirectory(string $dir, ?string $namespace = null): array
    {
        if (!is_dir($dir)) {
            return [];
        }

        $templates = [];
        foreach (
            Finder::create()
                ->files()
                ->followLinks()
                ->in($dir) as $file
        ) {
            $prefix = ($namespace !== null ? '@' . $namespace . '/' : '');
            $templates[] = $prefix . str_replace('\\', '/', $file->getRelativePathname());
        }

        return $templates;
    }
}
