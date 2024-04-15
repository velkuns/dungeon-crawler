<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Application\Service;

class CookieService
{
    /** @var array{
     *     expires: int,
     *     path: string,
     *     domain: string,
     *     secure: bool,
     *     httponly: bool,
     *     samesite: 'Lax'|'lax'|'None'|'none'|'Strict'|'strict'
     * } $defaultOptions
     */
    private array $defaultOptions;
    private \DateTimeImmutable $dateNow;

    /**
     * @param \DateTimeImmutable $dateNow
     * @param string $domain
     * @param int $defaultLifeTime
     * @param string $path
     * @param bool $isSecure
     * @param bool $isHttpOnly
     * @param 'Lax'|'lax'|'None'|'none'|'Strict'|'strict' $sameSite
     */
    public function __construct(
        \DateTimeImmutable $dateNow,
        string $domain,
        int $defaultLifeTime = 2592000,
        string $path = '/',
        bool $isSecure = true,
        bool $isHttpOnly = true,
        string $sameSite = 'None', // None || Lax  || Strict
    ) {
        $this->dateNow = $dateNow;

        //~ Build default options
        $this->defaultOptions = [
            'expires'  => $this->dateNow->getTimestamp() + $defaultLifeTime,
            'path'     => $path,
            'domain'   => $domain,
            'secure'   => $isSecure,
            'httponly' => $isHttpOnly,
            'samesite' => $sameSite,
        ];
    }

    /**
     * @param string $name
     * @param string $value
     * @param array{
     *     expires?: int,
     *     path?: string,
     *     domain?: string,
     *     secure?: bool,
     *     httponly?: bool,
     *     samesite?: 'Lax'|'lax'|'None'|'none'|'Strict'|'strict'
     * } $options
     * @return void
     */
    public function set(string $name, string $value, array $options = []): void
    {
        $options += $this->defaultOptions; // override default option & add missing options

        setcookie($name, $value, $options);
    }
}
