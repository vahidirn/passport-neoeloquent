<?php

namespace Laravel\Passport;

use VahidIrn\NeoEloquent\Eloquent\Model as NeoEloquent;

class Token extends NeoEloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauthAccessTokens';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'scopes' => 'array',
        'revoked' => 'bool',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the client that the token belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Passport::clientModel(), 'CLIENT_TOKENS');
    }

    /**
     * Get the user that the token belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        $provider = config('auth.guards.api.provider');

        return $this->belongsTo(config('auth.providers.'.$provider.'.model'));
    }

    /**
     * Determine if the token has a given scope.
     *
     * @param  string  $scope
     * @return bool
     */
    public function can($scope)
    {
        return in_array('*', $this->scopes) ||
               array_key_exists($scope, array_flip($this->scopes));
    }

    /**
     * Determine if the token is missing a given scope.
     *
     * @param  string  $scope
     * @return bool
     */
    public function cant($scope)
    {
        return ! $this->can($scope);
    }

    /**
     * Revoke the token instance.
     *
     * @return bool
     */
    public function revoke()
    {
        return $this->forceFill(['revoked' => true])->save();
    }

    /**
     * Determine if the token is a transient JWT token.
     *
     * @return bool
     */
    public function transient()
    {
        return false;
    }
}
