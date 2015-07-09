<?php

use Carbon\Carbon;
use Keep\Entities\Task;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskTest extends EntityTestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $this->assertBelongsTo('user', 'Keep\Entities\Task');
    }

    /** @test */
    public function it_belongs_to_many_tags()
    {
        $this->assertBelongsToMany('tags', 'Keep\Entities\Task');
    }

    /** @test */
    public function it_belongs_to_a_priority_level()
    {
        $this->assertBelongsTo('priority', 'Keep\Entities\Task');
    }

    /** @test */
    public function it_belongs_to_an_assignment()
    {
        $this->assertBelongsTo('assignment', 'Keep\Entities\Task');
    }

    /** @test */
    public function it_fetches_urgent_tasks()
    {
        factory('Keep\Entities\Task')->create(['title' => 'Foo', 'priority_id' => 1, 'finishing_date' => Carbon::now()->addDays(2)]);
        factory('Keep\Entities\Task')->create(['title' => 'Bar', 'priority_id' => 1, 'finishing_date' => Carbon::now()->addDays(3)]);
        factory('Keep\Entities\Task')->create(['priority_id' => 1, 'completed' => true]);
        factory('Keep\Entities\Task')->create(['priority_id' => 1, 'is_failed' => true]);
        factory('Keep\Entities\Task')->create(['priority_id' => 2]);
        $this->assertCount(2, Task::urgent()->get());
        $this->assertEquals('Foo', Task::urgent()->get()->first()->title);
        $this->assertEquals('Bar', Task::urgent()->get()->last()->title);
    }

    /** @test */
    public function it_fetches_completed_tasks()
    {
        factory('Keep\Entities\Task', 2)->create(['completed' => true]);
        factory('Keep\Entities\Task', 1)->create();
        $this->assertCount(2, Task::completed()->get());
    }

    /** @test */
    public function it_fetches_newest_tasks()
    {
        factory('Keep\Entities\Task', 2)->create(['is_failed' => true]);
        factory('Keep\Entities\Task')->create(['title' => 'Foo', 'created_at' => Carbon::now()->subDays(2)]);
        factory('Keep\Entities\Task')->create(['title' => 'Bar', 'created_at' => Carbon::now()->subDays(3)]);
        $this->assertCount(1, Task::newest()->take(1)->get());
        $this->assertCount(2, Task::newest()->take(2)->get());
        $this->assertCount(2, Task::newest()->take(3)->get());
        $this->assertEquals('Foo', Task::newest()->take(2)->get()->first()->title);
        $this->assertEquals('Bar', Task::newest()->take(2)->get()->last()->title);
    }

    /** @test */
    public function it_fetches_deadline_tasks()
    {
        factory('Keep\Entities\Task')->create(['title' => 'Foo', 'finishing_date' => Carbon::now()->addDays(2)]);
        factory('Keep\Entities\Task')->create(['finishing_date' => Carbon::now()->addDays(3)]);
        factory('Keep\Entities\Task')->create(['finishing_date' => Carbon::now()->addDays(4)->addHours(2)]);
        factory('Keep\Entities\Task')->create(['title' => 'Bar', 'finishing_date' => Carbon::now()->addDays(4)->addHours(5)]);
        factory('Keep\Entities\Task')->create(['completed' => true]);
        factory('Keep\Entities\Task')->create(['is_failed' => true]);
        $this->assertCount(1, Task::toDeadline()->take(1)->get());
        $this->assertCount(2, Task::toDeadline()->take(2)->get());
        $this->assertCount(3, Task::toDeadline()->take(3)->get());
        $this->assertCount(4, Task::toDeadline()->take(4)->get());
        $this->assertCount(4, Task::toDeadline()->take(5)->get());
        $this->assertCount(4, Task::toDeadline()->take(6)->get());
        $this->assertEquals('Foo', Task::toDeadline()->take(4)->get()->first()->title);
        $this->assertEquals('Bar', Task::toDeadline()->take(4)->get()->last()->title);
    }

    /** @test */
    public function it_fetches_recently_completed_tasks()
    {
        factory('Keep\Entities\Task', 2)->create(['completed' => false]);
        factory('Keep\Entities\Task')->create(['title' => 'Foo', 'completed' => true, 'finished_at' => Carbon::now()->addHours(2)]);
        factory('Keep\Entities\Task')->create(['title' => 'Bar', 'completed' => true, 'finished_at' => Carbon::now()->addHours(3)]);
        $this->assertCount(2, Task::recentlyCompleted()->get());
        $this->assertEquals('Foo', Task::recentlyCompleted()->get()->first()->title);
        $this->assertEquals('Bar', Task::recentlyCompleted()->get()->last()->title);
    }

    /** @test */
    public function it_fetches_tasks_that_are_about_to_failed()
    {
        factory('Keep\Entities\Task')->create(['completed' => true, 'finishing_date' => Carbon::now()->subDays(1)]);
        factory('Keep\Entities\Task')->create(['is_failed' => true, 'finishing_date' => Carbon::now()->subDays(2)]);
        factory('Keep\Entities\Task')->create(['finishing_date' => Carbon::now()->subHours(3)]);
        $this->assertCount(1, Task::aboutToFail()->get());
    }

    /** @test */
    public function it_fetches_recently_failed_tasks()
    {
        factory('Keep\Entities\Task', 2)->create(['is_failed' => false]);
        factory('Keep\Entities\Task')->create(['title' => 'Foo', 'is_failed' => true, 'created_at' => Carbon::now()->subHours(2)]);
        factory('Keep\Entities\Task')->create(['title' => 'Bar', 'is_failed' => true, 'created_at' => Carbon::now()->subHours(3)]);
        $this->assertCount(2, Task::recentlyFailed()->get());
        $this->assertEquals('Foo', Task::recentlyFailed()->get()->first()->title);
        $this->assertEquals('Bar', Task::recentlyFailed()->get()->last()->title);
    }

    /** @test */
    public function it_fetches_due_tasks()
    {
        factory('Keep\Entities\Task')->create(['is_failed' => true]);
        factory('Keep\Entities\Task')->create(['completed' => true]);
        factory('Keep\Entities\Task', 2)->create();
        $this->assertCount(2, Task::due()->get());
    }

    /** @test */
    public function it_fetches_user_created_tasks()
    {
        factory('Keep\Entities\Task')->create(['user_id' => 1]);
        factory('Keep\Entities\Task', 2)->create();
        $this->assertCount(1, Task::userCreated()->get());
    }

    /** @test */
    public function it_fetches_upcoming_tasks()
    {
        factory('Keep\Entities\Task')->create(['is_failed' => true]);
        factory('Keep\Entities\Task')->create(['completed' => true]);
        factory('Keep\Entities\Task')->create(['finishing_date' => Carbon::now()]);
        factory('Keep\Entities\Task')->create(['finishing_date' => Carbon::now()->addDays(3)]);
        factory('Keep\Entities\Task')->create(['finishing_date' => Carbon::now()->addDays(5)]);
        factory('Keep\Entities\Task')->create(['finishing_date' => Carbon::now()->addDays(6)]);
        $this->assertCount(3, Task::upcoming()->get());
    }

    /** @test */
    public function it_searches_for_tasks_by_titles()
    {
        factory('Keep\Entities\Task')->create(['title' => 'Foo']);
        factory('Keep\Entities\Task')->create(['title' => 'Foo Bar']);
        factory('Keep\Entities\Task')->create(['title' => 'Foo Bar Baz']);
        factory('Keep\Entities\Task')->create(['title' => 'Bar Baz']);
        factory('Keep\Entities\Task')->create(['title' => 'Baz']);
        $this->assertCount(3, Task::search('Foo')->get());
        $this->assertCount(3, Task::search('foo')->get());
        $this->assertCount(3, Task::search('Bar')->get());
        $this->assertCount(3, Task::search('Baz')->get());
        $this->assertCount(0, Task::search('Dummy')->get());
    }

    /** @test */
    public function it_has_the_correct_completed_status()
    {
        $task1 = factory('Keep\Entities\Task')->create(['completed' => true]);
        $task2 = factory('Keep\Entities\Task')->create(['completed' => false]);
        $this->assertSame(true, $task1->isCompleted());
        $this->assertSame(false, $task2->isCompleted());
    }

    /** @test */
    public function it_formats_starting_date_value_when_this_value_is_retrieved()
    {
        $task1 = factory('Keep\Entities\Task')->create(['starting_date' => Carbon::create(2015, 8, 8, 15, 45, 10)]);
        $task2 = factory('Keep\Entities\Task')->create(['starting_date' => Carbon::create(2014, 8, 8, 5, 45, 10)]);
        $this->assertSame('08/08/2015 03:45 PM', $task1->starting_date);
        $this->assertSame('08/08/2014 05:45 AM', $task2->starting_date);
    }

    /** @test */
    public function it_formats_finishing_date_value_when_this_value_is_retrieved()
    {
        $task1 = factory('Keep\Entities\Task')->create(['finishing_date' => Carbon::create(2015, 8, 8, 15, 45, 10)]);
        $task2 = factory('Keep\Entities\Task')->create(['finishing_date' => Carbon::create(2014, 8, 8, 5, 45, 10)]);
        $this->assertSame('08/08/2015 03:45 PM', $task1->finishing_date);
        $this->assertSame('08/08/2014 05:45 AM', $task2->finishing_date);
    }

    /** @test */
    public function it_fetches_the_array_of_id_of_all_associated_tags()
    {
        $tag1 = factory('Keep\Entities\Tag')->create();
        $tag2 = factory('Keep\Entities\Tag')->create();
        $task = factory('Keep\Entities\Task')->create();
        $task->tags()->attach([$tag1->id, $tag2->id]);
        $this->assertEquals([$tag1->id, $tag2->id], $task->tag_list);
    }
}
