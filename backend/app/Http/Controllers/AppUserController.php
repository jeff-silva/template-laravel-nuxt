<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\ApiResource;

#[Prefix('api')]
#[ApiResource(resource: 'app_user')]
class AppUserController extends Controller
{
    public function __construct(
        protected $model = new AppUser,
    ) {}
}
