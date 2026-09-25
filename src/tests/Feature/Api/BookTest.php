<?php

namespace Tests\Feature\Api;


use App\Common\Models\Book;
use App\Common\Models\Publisher;
use Illuminate\Http\Response;

class BookTest extends TestCaseApi
{
    public function testList(): void
    {
        $publisher = Publisher::factory()->create();
        $response = $this->actingAs($publisher)->getJson(route('api.books.list'));

        $response->assertJsonStructure(['data', 'meta'])->assertOk();
    }

    public function testBook(): void
    {
        $publisher = Publisher::factory()->has(Book::factory())->create();
        $response = $this->actingAs($publisher)
            ->getJson(route('api.books.book', $publisher->books->first()));

        $response->assertJsonStructure(['data'])->assertOk();
    }

    public function testCreate(): void
    {
        $requestData = array_rename_keys(
            data: Book::factory()->definition(),
            oldKeys: ['authors'],
            newKeys: ['author_names']
        );

        $publisher = Publisher::factory()->create();
        $response = $this->actingAs($publisher)
            ->postJson(route('api.books.store', $requestData));

        $response->assertValid()
            ->assertJsonStructure(['data'])
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testUpdatePartial(): void
    {
        $requestData = [
            'isbn' => fake()->unique()->isbn13()
        ];

        $publisher = Publisher::factory()->has(Book::factory())->create();
        $response = $this->actingAs($publisher)
            ->patchJson(
                route('api.books.update-partial', ['book' => $publisher->books->first()]),
                $requestData
            );

        $response->assertValid()
            ->assertJsonStructure(['data'])
            ->assertStatus(Response::HTTP_ACCEPTED);

    }

    public function testUpdate(): void
    {
        $requestData = array_rename_keys(
            data: Book::factory()->definition(),
            oldKeys: ['authors'],
            newKeys: ['author_names']
        );

        $publisher = Publisher::factory()->has(Book::factory())->create();
        $response = $this->actingAs($publisher)
            ->putJson(
                route('api.books.update', ['book' => $publisher->books->first()]),
                $requestData
            );

        $response->assertValid()
            ->assertJsonStructure(['data'])
            ->assertStatus(Response::HTTP_ACCEPTED);

    }

    public function testDelete(): void
    {
        $publisher = Publisher::factory()->has(Book::factory())->create();
        $book = $publisher->books->first();
        $response = $this->actingAs($publisher)
            ->deleteJson(route('api.books.remove', $book));

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertModelMissing($book);
    }
}
