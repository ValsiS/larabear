<?php declare(strict_types=1);

use GuardsmanPanda\Larabear\Web\Www\Dashboard\Controller\LarabearDashboardController;
use Illuminate\Support\Facades\Route;

Route::get(uri: '/', action: [LarabearDashboardController::class, 'index']);
