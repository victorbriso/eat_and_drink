<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HistoricalCashboxedTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HistoricalCashboxedTable Test Case
 */
class HistoricalCashboxedTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HistoricalCashboxedTable
     */
    protected $HistoricalCashboxed;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.HistoricalCashboxed',
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
        $config = $this->getTableLocator()->exists('HistoricalCashboxed') ? [] : ['className' => HistoricalCashboxedTable::class];
        $this->HistoricalCashboxed = $this->getTableLocator()->get('HistoricalCashboxed', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->HistoricalCashboxed);

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
