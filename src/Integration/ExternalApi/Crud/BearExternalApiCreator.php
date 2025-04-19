<?php declare(strict_types=1);

namespace GuardsmanPanda\Larabear\Integration\ExternalApi\Crud;

use GuardsmanPanda\Larabear\Infrastructure\Database\Service\BearDatabaseService;
use GuardsmanPanda\Larabear\Integration\ExternalApi\Enum\BearExternalApiTypeEnum;
use GuardsmanPanda\Larabear\Integration\ExternalApi\Model\BearExternalApi;
use Illuminate\Database\Eloquent\Casts\ArrayObject;
use Illuminate\Support\Str;
use InvalidArgumentException;

final class BearExternalApiCreator {
    /**
     * @param string $external_api_slug
     * @param string $external_api_description
     * @param BearExternalApiTypeEnum $external_api_type
     * @param string|null $id
     * @param string|null $encrypted_external_api_token
     * @param string|null $external_api_base_url
     * @param string|null $oauth2_user_id
     * @param string|null $oauth2_client_id
     * @param ArrayObject<string, string> $external_api_base_headers_json
     * @param ArrayObject<string|int, mixed> $external_api_metadata_json
     * @return BearExternalApi
     */
    public static function create(
        string $external_api_slug,
        string $external_api_description,
        BearExternalApiTypeEnum $external_api_type,
        string $id = null,
        string $encrypted_external_api_token = null,
        string $external_api_base_url = null,
        string $oauth2_user_id = null,
        string $oauth2_client_id = null,
        ArrayObject $external_api_base_headers_json = new ArrayObject([]),
        ArrayObject $external_api_metadata_json = new ArrayObject([]),
    ): BearExternalApi {
        BearDatabaseService::mustBeProperHttpMethod(verbs: ['POST', 'PUT', 'PATCH', 'DELETE']);

        $model = new BearExternalApi();
        $model->id = $id ?? Str::uuid()->toString();

        $model->external_api_slug = $external_api_slug;
        $model->external_api_description = $external_api_description;
        $model->external_api_type = $external_api_type;
        if ($external_api_type === BearExternalApiTypeEnum::BASIC_AUTH) {
            $model->encrypted_external_api_token = base64_encode($encrypted_external_api_token ?? throw new InvalidArgumentException(message: 'Basic Auth requires a username:password'));
        } else {
            $model->encrypted_external_api_token = $encrypted_external_api_token;
        }
        $model->external_api_base_url = $external_api_base_url;
        $model->oauth2_user_id = $oauth2_user_id;
        $model->oauth2_client_id = $oauth2_client_id;
        $model->external_api_base_headers_json = $external_api_base_headers_json;
        $model->external_api_metadata_json = $external_api_metadata_json;

        $model->save();
        return $model;
    }
}
