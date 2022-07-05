<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /*protected $fillable = ['name'];*/
    protected $guarded = [];

    public $incrementing = false;

    public function members()
    {
        return GroupMember::where(["group_id"=>$this->id]);
    }

    public function hasMembers()
    {
        return count($this->members()->get());
    }
}
