<?php declare(strict_types=1);

namespace GuardsmanPanda\Larabear\Infrastructure\Auth\Crud;

use Carbon\CarbonInterface;
use GuardsmanPanda\Larabear\Infrastructure\App\Service\BearGlobalStateService;
use GuardsmanPanda\Larabear\Infrastructure\Auth\Enum\BearUserLoginTypeEnum;
use GuardsmanPanda\Larabear\Infrastructure\Auth\Enum\BearUserTokenTypeEnum;
use GuardsmanPanda\Larabear\Infrastructure\Auth\Model\BearAccessTokenUser;
use GuardsmanPanda\Larabear\Infrastructure\Auth\Model\BearUser;
use GuardsmanPanda\Larabear\Infrastructure\Database\Service\BearDatabaseService;
use GuardsmanPanda\Larabear\Infrastructure\Http\Service\Req;

final class BearAccessTokenUserCreator {
    public static function create(
        BearUser $user,
        CarbonInterface $expires_at,
        BearUserTokenTypeEnum $user_token_type = BearUserTokenTypeEnum::BEARER,
    ): String {
        BearDatabaseService::mustBeProperHttpMethod(verbs: ['POST', 'PUT', 'PATCH', 'DELETE']);

        BearUserLoginHistoryCreator::create(user_id: $user->id, login_type: BearUserLoginTypeEnum::USER_API);
        (new BearUserUpdater($user))->setLastLoginNow()->update();

        $model = new BearAccessTokenUser();
        $token = bin2hex(string: random_bytes(length: 32));

        $model->hashed_token = hash(algo: 'xxh128', data: $token);
        $model->user_id = $user->id;
        $model->expires_at = $expires_at;
        $model->user_token_type = $user_token_type;

        $model->save();
        return $token;
    }
}
