<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class NoteTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetNotes()
    {
        $token = $this->getToken();

        $this->json('GET', 'api/notes', [], ['Authorization' => 'Bearer ' . $token])
            ->shouldReturnJson()
            ->assertResponseOk();
    }

    public function testFindNote()
    {
        $token = $this->getToken();

        $this->json('GET', 'api/notes/1', [], ['Authorization' => 'Bearer ' . $token])
            ->shouldReturnJson()
            ->assertResponseOk();
    }

    public function testStoreNote()
    {
        $token = $this->getToken();
        $data  = [
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod'
        ];

        $this->json('POST', 'api/notes', $data, ['Authorization' => 'Bearer ' . $token])
            ->shouldReturnJson()
            ->seeJsonEquals([
                "message" => "note_stored"
            ])
            ->seeJsonStructure([
                'message'
            ])
            ->assertResponseOk();
    }

    public function testUpdateNote()
    {
        $token = $this->getToken();
        $data  = [
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod'
        ];

        $this->json('PUT', 'api/notes/1', $data, ['Authorization' => 'Bearer ' . $token])
            ->shouldReturnJson()
            ->seeJsonEquals([
                "message" => "note_updated"
            ])
            ->seeJsonStructure([
                'message'
            ])
            ->assertResponseOk();
    }

    public function testDeleteNote()
    {
        $token = $this->getToken();

        $this->json('DELETE', 'api/notes/1', [], ['Authorization' => 'Bearer ' . $token])
            ->shouldReturnJson()
            ->seeJsonEquals([
                "message" => "note_deleted"
            ])
            ->seeJsonStructure([
                'message'
            ])
            ->assertResponseOk();
    }
}
