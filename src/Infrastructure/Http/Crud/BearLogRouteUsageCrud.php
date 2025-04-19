<?php declare(strict_types=1);

namespace GuardsmanPanda\Larabear\Infrastructure\Http\Crud;

use GuardsmanPanda\Larabear\Infrastructure\Database\Service\BearDatabaseService;
use GuardsmanPanda\Larabear\Infrastructure\Http\Service\Req;
use Illuminate\Support\Facades\DB;

final class BearLogRouteUsageCrud {
    public static function createOrUpdate(int $multiply = 1): void {
        $method = Req::method();
        $route = Req::routePath();
        $action = Req::actionName();
        if ($route === null || $action === null) {
            return;
        }
        $time = 0;
        if (defined(constant_name: 'LARAVEL_START')) {
            $time = (int)((microtime(as_float: true) - get_defined_constants()['LARAVEL_START']) * 1_000_000 * $multiply);
        }
        if (BearDatabaseService::defaultConnectionDriver() === 'pgsql') {
            DB::insert(query: "
            INSERT INTO bear_log_route_usage (request_http_method, request_route_path, app_action_name, route_usage_count, route_usage_time_microseconds)
            VALUES (?, ?, ?, ?, ?)
            ON CONFLICT (request_http_method, request_route_path, app_action_name)  DO UPDATE SET
                last_usage_at = NOW(),                                                                                                  
                route_usage_count = bear_log_route_usage.route_usage_count + excluded.route_usage_count,
                route_usage_time_microseconds = bear_log_route_usage.route_usage_time_microseconds + excluded.route_usage_time_microseconds
        ", bindings: [$method, $route, $action, $multiply, $time]);
        } else {
            DB::insert(query: "
            INSERT INTO bear_log_route_usage (request_http_method, request_route_path, app_action_name, route_usage_count, route_usage_time_microseconds)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                `last_usage_at` = NOW(),
                `route_usage_count` = `route_usage_count` + VALUES(`route_usage_count`),
                `route_usage_time_microseconds` = `route_usage_time_microseconds` + VALUES(`route_usage_time_microseconds`)
        ", bindings: [$method, $route, $action, $multiply, $time]);
        }
    }
}
