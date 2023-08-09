<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GeneralSaleDaysTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GeneralSaleDaysTable Test Case
 */
class GeneralSaleDaysTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GeneralSaleDaysTable
     */
    protected $GeneralSaleDays;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GeneralSaleDays',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GeneralSaleDays') ? [] : ['className' => GeneralSaleDaysTable::class];
        $this->GeneralSaleDays = $this->getTableLocator()->get('GeneralSaleDays', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GeneralSaleDays);

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
