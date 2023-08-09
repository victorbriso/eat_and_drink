<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Users',
        'app.Bookings',
        'app.BuyDetails',
        'app.BuySummaries',
        'app.Cancellations',
        'app.CashboxMovements',
        'app.Cashboxes',
        'app.Categories',
        'app.Cellars',
        'app.Comandas',
        'app.FixedCosts',
        'app.FolioCashes',
        'app.Folios',
        'app.HistoricalCommands',
        'app.InventoryMovements',
        'app.Orders',
        'app.PlaceElaborations',
        'app.PriceListControls',
        'app.PriceLists',
        'app.Products',
        'app.Profiles',
        'app.SaleForDays',
        'app.Salons',
        'app.Tables',
        'app.Usuarios',
        'app.Vendors',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Users);

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
