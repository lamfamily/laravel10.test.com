## 无限级分类例子
- composer require kalnoy/nestedset
- php artisan make:model Category -m
- vim xxx_create_categories_table.php
```php
$table->id();
$table->string('name');
$table->string('slug')->unique();
// NestedSet 必需的字段
$table->nestedSet();
$table->timestamps();
```
- vim app/Models/Category.php
```php
use HasFactory, NodeTrait;

protected $fillable = ['name', 'slug'];
```
- php artisan migrate
- php artisan make:controller CategoryController --resource
- 内容太多，看控制器代码
