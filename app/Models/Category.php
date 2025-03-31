<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = ['name', 'slug'];

    // 添加 pid 虚拟属性
    protected $appends = ['pid'];

    /**
     * 获取 pid 属性
     *
     * @return mixed
     */
    public function getPidAttribute()
    {
        return $this->parent_id;
    }

    /**
     * 设置 pid 属性
     *
     * @param mixed $value
     * @return void
     */
    public function setPidAttribute($value)
    {
        $this->attributes['parent_id'] = $value;
    }
}
