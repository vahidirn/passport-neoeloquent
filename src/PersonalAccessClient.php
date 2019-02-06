<?php

namespace Laravel\Passport;

use VahidIrn\NeoEloquent\Eloquent\Model as NeoEloquent;

class PersonalAccessClient extends NeoEloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauthPersonalAccessClients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
    ];
    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all of the authentication codes for the client.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Passport::clientModel(), 'PERSONAL_ACCESS_CLIENT');
    }
}
