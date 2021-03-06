<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function it_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function it_can_create_its_own_string_path()
    {
        $this->assertEquals('/threads/' . $this->thread->channel->slug . '/' . $this->thread->id, $this->thread->path());
    }

    /** @test */
    public function it_has_an_owner()
    {
        $this->assertInstanceOf(\App\User::class, $this->thread->creator);
    }

    /** @test */
    public function it_can_save_reply()
    {
        $this->thread->addReply([
            'body' => 'Fake Reply',
            'user_id' => 1
        ]);
        
        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function it_has_a_channel()
    {
        $thread = make('App\Thread');

        $this->assertInstanceOf(\App\Channel::class, $thread->channel);
    }
}
