<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FoliosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FoliosTable Test Case
 */
class FoliosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FoliosTable
     */
    protected $Folios;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Folios',
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
        $config = $this->getTableLocator()->exists('Folios') ? [] : ['className' => FoliosTable::class];
        $this->Folios = $this->getTableLocator()->get('Folios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Folios);

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
