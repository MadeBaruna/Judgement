<?php

namespace Judgement;

use Illuminate\Database\Eloquent\Model;

/**
 * Judgement\Group
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Judgement\User[] $users
 * @property-read \Judgement\User $leader
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property integer $leader_id
 * @method static \Illuminate\Database\Query\Builder|\Judgement\Group whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Judgement\Group whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Judgement\Group whereLeaderId($value)
 */
class Group extends Model
{
    public function members()
    {
        return $this->belongsToMany('Judgement\User');
    }

    public function leader()
    {
        return $this->belongsTo('Judgement\User', 'leader_id');
    }
}
