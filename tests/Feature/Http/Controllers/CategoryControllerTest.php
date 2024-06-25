<?php

use App\Http\Controllers\CategoryController;
use App\Services\CategoryService;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->categoryService = Mockery::mock(CategoryService::class);
    $this->controller = new CategoryController($this->categoryService);
});

test('index method returns view', function () {
    $view = $this->controller->index();
    $this->assertEquals('category.index', $view->name());
});

test('data method returns datatables json', function () {
    $this->categoryService->shouldReceive('getAllCategories')->once()->andReturn(collect());
    $response = $this->controller->data();
    $this->assertTrue($response->isSuccessful());
});

test('store method creates category and returns json', function () {
    $request = new Request(['categoryName' => 'Test Category']);
    $this->categoryService->shouldReceive('createCategory')->once()->with('Test Category');
    $response = $this->controller->store($request);
    $this->assertEquals(201, $response->getStatusCode());
    $this->assertEquals("\"Data berhasil disimpan!\"", $response->getContent());
});

test('show method returns category json', function () {
    $this->categoryService->shouldReceive('getCategoryById')->once()->with(1)->andReturn((object)['id' => 1, 'name' => 'Test Category']);
    $response = $this->controller->show(1);
    $this->assertTrue($response->isSuccessful());
});

test('update method updates category and returns json', function () {
    $request = new Request(['categoryName' => 'Updated Category']);
    $this->categoryService->shouldReceive('updateCategory')->once()->with(1, 'Updated Category');
    $response = $this->controller->update($request, 1);
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertEquals("\"Data berhasil diperbarui!\"", $response->getContent());
});

test('destroy method deletes category and returns json', function () {
    $this->categoryService->shouldReceive('deleteCategory')->once()->with(1);
    $response = $this->controller->destroy(1);
    $this->assertEquals(204, $response->getStatusCode());
    $this->assertEquals("\"Data berhasil dihapus!\"", $response->getContent());
});
