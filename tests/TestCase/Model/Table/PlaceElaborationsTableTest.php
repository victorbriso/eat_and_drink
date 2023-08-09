<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlaceElaborationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlaceElaborationsTable Test Case
 */
class PlaceElaborationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlaceElaborationsTable
     */
    protected $PlaceElaborations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PlaceElaborations',
        'app.Users',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PlaceElaborations') ? [] : ['className' => PlaceElaborationsTable::class];
        $this->PlaceElaborations = $this->getTableLocator()->get('PlaceElaborations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PlaceElaborations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
