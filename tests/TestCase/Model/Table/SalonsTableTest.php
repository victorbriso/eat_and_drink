<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SalonsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SalonsTable Test Case
 */
class SalonsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SalonsTable
     */
    protected $Salons;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Salons',
        'app.Users',
        'app.Cashboxes',
        'app.Comandas',
        'app.Tables',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Salons') ? [] : ['className' => SalonsTable::class];
        $this->Salons = $this->getTableLocator()->get('Salons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Salons);

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
