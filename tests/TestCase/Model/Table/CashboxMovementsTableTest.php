<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CashboxMovementsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CashboxMovementsTable Test Case
 */
class CashboxMovementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CashboxMovementsTable
     */
    protected $CashboxMovements;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CashboxMovements',
        'app.Users',
        'app.Cashboxes',
        'app.FolioCashes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CashboxMovements') ? [] : ['className' => CashboxMovementsTable::class];
        $this->CashboxMovements = $this->getTableLocator()->get('CashboxMovements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CashboxMovements);

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
