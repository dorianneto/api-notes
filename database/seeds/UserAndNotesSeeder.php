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
        $User            = new User;
        $User->name      = 'Default';
        $User->password  = Hash::make('admin');
        $User->email     = 'admin@admin.com.br';
        $User->save();

        $this->userId = $User->id;

        echo "Generated an user!\n";
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
                'user_id' => $this->userId
            ],
            [
                'text'    => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat',
                'user_id' => $this->userId
            ]
        ];

        Note::insert($data);

        echo "User's notes generated!\n";
    }
}
