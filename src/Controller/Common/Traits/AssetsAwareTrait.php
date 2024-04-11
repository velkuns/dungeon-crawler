<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Controller\Common\Traits;

trait AssetsAwareTrait
{
    protected string $rootDirectory;

    /** @var string[][] $jsFiles */
    protected array $jsFiles = [];

    /** @var string[][] $cssFiles */
    protected array $cssFiles = [];

    public function setRootDirectory(string $rootDirectory): void
    {
        $this->rootDirectory = $rootDirectory;
    }

    /**
     * @return string[][]
     */
    protected function getCssFiles(): array
    {
        return $this->cssFiles;
    }

    /**
     * @return string[][]
     */
    protected function getJsFiles(): array
    {
        return $this->jsFiles;
    }

    /**
     * @throws \JsonException
     */
    protected function initializeAssets(): void
    {
        $entryFile    = $this->rootDirectory . '/web/assets/entrypoints.json';
        $manifestFile = $this->rootDirectory . '/web/assets/manifest.json';

        if (!is_readable($entryFile) || !is_readable($manifestFile)) {
            throw new \RuntimeException('entrypoints.json or manifest.json file is not readable.');
        }

        /** @var array{entrypoints: array{app: array{js: string[], css: string[]}}} $entrypoints */
        $entrypoints = json_decode(
            (string) file_get_contents($entryFile),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->cssFiles = [];
        $this->jsFiles  = [];

        $existingFiles = [
            'js'  => [],
            'css' => [],
        ];

        foreach ($entrypoints['entrypoints'] as $entryName => $entrypoint) {
            $this->jsFiles[$entryName]  = [];
            $this->cssFiles[$entryName] = [];

            foreach ($entrypoint['js'] as $file) {
                if (!isset($existingFiles['js'][$file])) {
                    $existingFiles['js'][$file] = true;
                    $this->jsFiles[$entryName][]  = $file;
                }
            }

            foreach ($entrypoint['css'] as $file) {
                if (!isset($existingFiles['css'][$file])) {
                    $existingFiles['css'][$file] = true;
                    $this->cssFiles[$entryName][]  = $file;
                }
            }
        }
    }
}
