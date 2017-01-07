<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Note;

class UserAndNotesSeeder extends Seeder
{
    /**
     * User ID
     * @var int
     */
    private $userId;

    /**
     * Tester ID
     * @var int
     */
    private $testerId;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->storeUser();
        $this->storeNotes();
    }

    /**
     * Stores an user on database
     * @return void
     */
    protected function storeUser()
    {
        $Tester            = new User;
        $Tester->name      = 'Test';
        $Tester->password  = Hash::make('3z5DSDPP');
        $Tester->email     = 'test@test.com';
        $Tester->save();

        $this->testerId = $Tester->id;

        $User            = new User;
        $User->name      = 'User';
        $User->password  = Hash::make('lk89MTQW');
        $User->email     = 'user@user.com';
        $User->save();

        $this->userId = $User->id;

        echo "Users generated!\n";
    }

    /**
     * Stores user notes on database
     * @return void
     */
    protected function storeNotes()
    {
        $data = [
            [
                'text'    => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor',
                'user_id' => $this->testerId
            ],
            [
                'text'    => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat',
                'user_id' => $this->userId
            ]
        ];

        Note::insert($data);

        echo "Notes generated!\n";
    }
}
