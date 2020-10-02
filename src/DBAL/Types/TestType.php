<?php

declare(strict_types=1);

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class TestType extends AbstractEnumType
{
    public const TEST_TYPE_1 = 'type1';
    public const TEST_TYPE_2 = 'type2';

    protected static $choices = [
        self::TEST_TYPE_1 => 'Test type 1',
        self::TEST_TYPE_2 => 'Test type 2',
    ];
}
