<?php

declare(strict_types=1);

/*
 * This file is part of Contao Redirect Bundle.
 *
 * (c) Hamid Peywasti 2025 <hamid@respinar.com>
 *
 * @license MIT
 */

namespace Respinar\ContaoRedirectBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Respinar\ContaoRedirectBundle\RespinarContaoRedirectBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(RespinarContaoRedirectBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
