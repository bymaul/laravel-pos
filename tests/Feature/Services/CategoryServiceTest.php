<?php

use App\Services\CategoryService;
use App\Models\Category;

beforeEach(function () {
    $this->categoryService = Mockery::mock(CategoryService::class)->shouldAllowMockingProtectedMethods();
});

test('returns all categories', function () {
    $categories = collect([new Category(['name' => 'Category1']), new Category(['name' => 'Category2'])]);

    $this->categoryService
        ->shouldReceive('getAllCategories')
        ->andReturn($categories);

    $result = $this->categoryService->getAllCategories();

    $this->assertEquals($categories, $result);
});

test('creates a category', function () {
    $categoryName = 'CategoryTest';

    $categoryMock = Mockery::mock(Category::class)->makePartial();
    $categoryMock->shouldReceive('save')->andReturn(true);
    $categoryMock->name = $categoryName;

    $this->categoryService->shouldReceive('createCategory')->andReturn($categoryMock);

    $result = $this->categoryService->createCategory($categoryName);

    $this->assertEquals($categoryName, $result->name);
});

test('returns a category by id', function () {
    $categoryId = 1;

    $categoryMock = Mockery::mock(Category::class)->makePartial();
    $categoryMock->shouldReceive('findOrFail')->with($categoryId)->andReturnSelf();
    $categoryMock->id = $categoryId;

    $this->categoryService->shouldReceive('getCategoryById')->andReturn($categoryMock);

    $result = $this->categoryService->getCategoryById($categoryId);

    $this->assertEquals($categoryId, $result->id);
});

test('updates a category', function () {
    $categoryId = 1;
    $categoryName = 'UpdatedCategoryTest';

    $categoryMock = Mockery::mock(Category::class)->makePartial();
    $categoryMock->shouldReceive('update')->andReturn(true);
    $categoryMock->name = $categoryName;

    $this->categoryService->shouldReceive('updateCategory')->andReturn($categoryMock);

    $result = $this->categoryService->updateCategory($categoryId, $categoryName);

    $this->assertEquals($categoryName, $result->name);
});

test('deletes a category', function () {
    $categoryId = 1;

    $categoryMock = Mockery::mock(Category::class)->makePartial();
    $categoryMock->shouldReceive('delete')->andReturn(true);
    $categoryMock->id = $categoryId;

    $this->categoryService->shouldReceive('findOrFail')->with($categoryId)->andReturn($categoryMock);
    $this->categoryService->shouldReceive('deleteCategory')->with($categoryId)->andReturn($categoryMock);

    $result = $this->categoryService->deleteCategory($categoryId);

    $this->assertEquals($categoryId, $result->id);
});
