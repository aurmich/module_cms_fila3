<?php

namespace Modules\SaluteMo\Tests\Support\Models;

use Modules\SaluteMo\Models\BaseModel;

class TestBaseModel extends BaseModel
{
    protected $table = 'test_models';
    protected $connection = 'sqlite';
}