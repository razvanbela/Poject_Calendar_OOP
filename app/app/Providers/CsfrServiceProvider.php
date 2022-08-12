<?php

declare(strict_types=1);

namespace App\Providers;

use App\Security\Csfr;
use App\Session\SessionStore;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CsfrServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [Csfr::class];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Csfr::class, function () use ($container) {
            return new Csfr(
                $container->get(SessionStore::class)
            );
        });
    }
}