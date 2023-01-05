<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Admins seed.
 */
class AdminsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $now = new \DateTime();

        $data = [
            [
                'id' => '1',
                'created' => $now->format('Y-m-d H:i:s'),
                'modified' => $now->format('Y-m-d H:i:s'),
                'name' => '管理者',
                'username' => 'caters_admin',
                'password' => '$2y$10$7X.icRPhUBnFrsoBR784y.VMC9IrXxbbinEff3WMGa0N.WG3D8kH6',
                'role' => '0',
            ],
        ];

        $table = $this->table('admins');
        $table->insert($data)->save();
    }
}
