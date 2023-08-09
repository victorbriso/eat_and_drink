<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HistoricalCommandsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HistoricalCommandsTable Test Case
 */
class HistoricalCommandsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HistoricalCommandsTable
     */
    protected $HistoricalCommands;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.HistoricalCommands',
        'app.Users',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('HistoricalCommands') ? [] : ['className' => HistoricalCommandsTable::class];
        $this->HistoricalCommands = $this->getTableLocator()->get('HistoricalCommands', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->HistoricalCommands);

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
