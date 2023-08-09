<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CashboxesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CashboxesTable Test Case
 */
class CashboxesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CashboxesTable
     */
    protected $Cashboxes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Cashboxes',
        'app.Users',
        'app.Salons',
        'app.Usuarios',
        'app.CashboxMovements',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cashboxes') ? [] : ['className' => CashboxesTable::class];
        $this->Cashboxes = $this->getTableLocator()->get('Cashboxes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Cashboxes);

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
