<?php declare(strict_types=1);

namespace GuardsmanPanda\Larabear\Infrastructure\Idempotency\Service;


use Carbon\CarbonInterface;
use GuardsmanPanda\Larabear\Infrastructure\Idempotency\Crud\BearIdempotencyCreator;
use GuardsmanPanda\Larabear\Infrastructure\Idempotency\Crud\BearIdempotencyDeleter;
use GuardsmanPanda\Larabear\Infrastructure\Idempotency\Model\BearIdempotency;

final class BearIdempotencyService {
    public static function tryKey(string $idempotencyKey, CarbonInterface $expiresAt): bool {
        $old = BearIdempotency::find(id: $idempotencyKey);
        if ($old !== null && $old->expires_at > now()) {
            return false;
        }
        if ($old !== null) {
            BearIdempotencyDeleter::delete(model: $old);
        }
        BearIdempotencyCreator::create(idempotency_key: $idempotencyKey, expires_at: $expiresAt);
        return true;
    }
}
