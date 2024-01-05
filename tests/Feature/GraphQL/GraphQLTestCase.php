<?php

declare(strict_types=1);

namespace Tests\Feature\GraphQL;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\TestCase;

abstract class GraphQLTestCase extends TestCase
{
    use MakesGraphQLRequests;
    use DatabaseTransactions;
}
