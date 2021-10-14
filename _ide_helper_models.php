<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @mixin IdeHelperUser
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $username
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $tagline
 * @property string|null $about
 * @property string|null $location
 * @property string|null $formatted_address
 * @property int $available_to_hire
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User comparison($geometryColumn, $geometry, $relationship)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User contains($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User crosses($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User disjoint($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distance($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceSphere($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceSphereExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceSphereValue($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User distanceValue($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User doesTouch($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User equals($geometryColumn, $geometry)
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User intersects($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User newModelQuery()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User newQuery()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User orderByDistance($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User orderByDistanceSphere($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User orderBySpatial($geometryColumn, $geometry, $orderFunction, $direction = 'asc')
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User overlaps($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User query()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereAbout($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereAvailableToHire($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereEmail($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereFormattedAddress($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereId($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereLocation($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereName($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User wherePassword($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereTagline($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User whereUsername($value)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|User within($geometryColumn, $polygon)
 */
	class IdeHelperUser extends \Eloquent {}
}

