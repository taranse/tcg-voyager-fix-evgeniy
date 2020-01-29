<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Events\SettingUpdated;

class SettingGroup extends Model
{
    protected $table = 'settings_group';

    protected $guarded = [];

    public $timestamps = false;
}
