<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UnitTestCase extends TestCase
{
    use DatabaseTransactions;
}