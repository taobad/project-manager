# Laravel Auth0 Plugin

[![CircleCI](https://img.shields.io/circleci/project/github/auth0/laravel-auth0/master.svg)](https://circleci.com/gh/auth0/laravel-auth0)
[![Latest Stable Version](https://poser.pugx.org/auth0/login/v/stable)](https://packagist.org/packages/auth0/login)
[![License](https://poser.pugx.org/auth0/login/license)](https://packagist.org/packages/auth0/login)
[![Total Downloads](https://poser.pugx.org/auth0/login/downloads)](https://packagist.org/packages/auth0/login)
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fauth0%2Flaravel-auth0.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2Fauth0%2Flaravel-auth0?ref=badge_shield)

This plugin helps you integrate your [Laravel](https://laravel.com/) WebApp with [Auth0](https://auth0.com/) to achieve Single Sign On with a few simple steps.

## Supported Framework Versions

Our plugin maintains support for [all actively supported versions](https://laravel.com/docs/8.x/releases#support-policy) of the Laravel framework, including [6.X (LTS)](https://laravel.com/docs/8.x/releases), [7.X](https://laravel.com/docs/7.x/releases) and [8.X](https://laravel.com/docs/8.x/releases).

Past releases of our plugin may potentially run on earlier, now unsupported versions of the Laravel framework, but these releases are not maintained. The final release of our plugin to support the Laravel 5.X series was 6.1.0.

## Documentation

Please see the [Laravel webapp quickstart](https://auth0.com/docs/quickstart/webapp/laravel) for a complete guide on how to install this in an existing project or to download a pre-configured sample project. Additional documentation on specific scenarios is below.

### Setting up a JWKs cache

In the `register` method of your `AppServiceProvider` add:

```php
// app/Providers/AppServiceProvider.php
use Illuminate\Support\Facades\Cache;
// ...
    public function register()
    {
        // ...
        $this->app->bind(
            '\Auth0\SDK\Helpers\Cache\CacheHandler',
            function() {
                static $cacheWrapper = null;
                if ($cacheWrapper === null) {
                $cache = Cache::store();
                $cacheWrapper = new LaravelCacheWrapper($cache);
            }
            return $cacheWrapper;
        });
    }
```

You can implement your own cache strategy by creating a new class that implements the `Auth0\SDK\Helpers\Cache\CacheHandler` contract, or just use the cache strategy you want by picking that store with `Cache::store('your_store_name')`;

### Storing users in your database

You can customize the way you handle the users in your application by creating your own `UserRepository`. This class should implement the `Auth0\Login\Contract\Auth0UserRepository` contract. Please see the [Custom User Handling section of the Laravel Quickstart](https://auth0.com/docs/quickstart/webapp/laravel#optional-custom-user-handling) for the latest example.

### Using auth guard

To protect APIs using an access token generated by Auth0, there is an `auth0` API guard provided ([Laravel documentation on guards](https://laravel.com/docs/7.x/authentication#adding-custom-guards)). To use this guard, add it to `config/auth.php` with the driver `auth0`:

```
'guards' => [
    ...
    'auth0' => [
        'driver' => 'auth0',
        'provider' => 'auth0',
    ],
],

'providers' => [
    ...
    'auth0' => [
        'driver' => 'auth0',
    ],
],
```

Once that has been added, add the guard to the middleware of any API route and check authentication during the request:

```
// get user
auth('auth0')->user();
// check if logged in
auth('auth0')->check();
// protect routes via middleware use
Route::group(['middleware' => 'auth:auth0'], function () {});
```

## Examples

### Organizations (Closed Beta)

Organizations is a set of features that provide better support for developers who build and maintain SaaS and Business-to-Business (B2B) applications.

Using Organizations, you can:

- Represent teams, business customers, partner companies, or any logical grouping of users that should have different ways of accessing your applications, as organizations.
- Manage their membership in a variety of ways, including user invitation.
- Configure branded, federated login flows for each organization.
- Implement role-based access control, such that users can have different roles when authenticating in the context of different organizations.
- Build administration capabilities into your products, using Organizations APIs, so that those businesses can manage their own organizations.

Note that Organizations is currently only available to customers on our Enterprise and Startup subscription plans.

#### Logging in with an Organization

Open your Auth0 Laravel plugin configuration file (usually `config/laravel-auth0.php`) uncomment the `organization` optiion and specify the Id for your Organization (found in your Organization settings on the Auth0 Dashboard.)

```php
// config/laravel-auth0.php
// ...

/*
|--------------------------------------------------------------------------
|   Auth0 Organizations
|--------------------------------------------------------------------------
|   organization (string) Optional. Id of an Organization, if being used. Used when generating log in urls and validating token claims.
*/

'organization' => 'org_E6WbrPMQU2UJn6Rz',
```

From there, the Organization will automatically be used throughout your Laravel application's authentication login, including redirecting to the Universal Login page.

```php
// Expects the Laravel plugin to be configured first, as demonstrated above.

App::make('auth0')->login();
```

#### Accepting user invitations

Auth0 Organizations allow users to be invited using emailed links, which will direct a user back to your application. The URL the user will arrive at is based on your configured `Application Login URI`, which you can change from your Application's settings inside the Auth0 dashboard.

When the user arrives at your application using an invite link, you can expect three query parameters to be provided: `invitation`, `organization`, and `organization_name`. These will always be delivered using a GET request.

A helper function is provided to handle extracting these query parameters and automatically redirecting to the Universal Login page. Invoke this from your application's logic, such as a controller for an authentication route, to handle this process automatically.

```php
// routes/example.php

Route::get('/invite', [ExampleIndexController::class, 'invite'])->name('invite');
```

```php
// Http/Controllers/Example/ExampleIndexController.php

<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class ExampleIndexController extends Controller
{
  /**
   * Redirect to Auth0 Universal Login using the invitation code
   *
   * @return void
   */
  public function invite()
  {
      App::make('auth0')->handleInvitation();
  }

```

## Installation

Install this plugin into a new or existing project using [Composer](https://getcomposer.org/doc/00-intro.md):

```bash
$ composer require auth0/login:"~6.0"
```

Additional steps to install can be found in the [quickstart](https://auth0.com/docs/quickstart/webapp/laravel#integrate-auth0-in-your-application).

## Contributing

We appreciate feedback and contribution to this repo! Before you get started, please see the following:

- [Auth0's Contribution guidelines](https://github.com/auth0/.github/blob/master/CONTRIBUTING.md)
- [Auth0's Code of Conduct](https://github.com/auth0/open-source-template/blob/master/CODE-OF-CONDUCT.md)

## Support + Feedback

Include information on how to get support. Consider adding:

- Use [Community](https://community.auth0.com/tags/laravel) for usage, questions, specific cases
- Use [Issues](https://github.com/auth0/laravel-auth0/issues) for code-level support

## What is Auth0?

Auth0 helps you to easily:

- implement authentication with multiple identity providers, including social (e.g., Google, Facebook, Microsoft, LinkedIn, GitHub, Twitter, etc), or enterprise (e.g., Windows Azure AD, Google Apps, Active Directory, ADFS, SAML, etc.)
- log in users with username/password databases, passwordless, or multi-factor authentication
- link multiple user accounts together
- generate signed JSON Web Tokens to authorize your API calls and flow the user identity securely
- access demographics and analytics detailing how, when, and where users are logging in
- enrich user profiles from other data sources using customizable JavaScript rules

[Why Auth0?](https://auth0.com/why-auth0)

## License

The Auth0 Laravel Login plugin is licensed under MIT - [LICENSE](LICENSE.txt)

[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fauth0%2Flaravel-auth0.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Fauth0%2Flaravel-auth0?ref=badge_large)