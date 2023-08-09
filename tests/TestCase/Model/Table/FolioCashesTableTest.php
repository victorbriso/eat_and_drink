<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FolioCashesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FolioCashesTable Test Case
 */
class FolioCashesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FolioCashesTable
     */
    protected $FolioCashes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.FolioCashes',
        'app.Users',
        'app.CashboxMovements',
        'app.Orders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FolioCashes') ? [] : ['className' => FolioCashesTable::class];
        $this->FolioCashes = $this->getTableLocator()->get('FolioCashes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->FolioCashes);

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
