<?php declare(strict_types=1);

namespace GuardsmanPanda\Larabear\Infrastructure\Auth\Crud;

use GuardsmanPanda\Larabear\Infrastructure\Database\Service\BearDatabaseService;
use GuardsmanPanda\Larabear\Infrastructure\Auth\Model\BearRole;

final class BearRoleCreator {
    public static function create(
        string $role_slug,
        string $role_description = null
    ): BearRole {
        BearDatabaseService::mustBeProperHttpMethod(verbs: ['POST', 'PUT', 'PATCH', 'DELETE']);

        $model = new BearRole();

        $model->role_slug = $role_slug;
        $model->role_description = $role_description;

        $model->save();
        return $model;
    }
}
