<?php

declare(strict_types=1);

namespace Behaviors\Iterator;

use Iterator;

/**
 * Паттерн Итератор позволяет нам скрыть детали работы с коллекцией элементов и обеспечивает удобный доступ к элементам последовательно,
 * независимо от типа коллекции и способа ее представления.
 */
class Task
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
    ) {
    }
}

class TaskList implements Iterator
{
    private array $tasks;
    private int $position;

    public function __construct()
    {
        $this->tasks = [];
        $this->position = 0;
    }

    public function addTask(Task $task): void
    {
        $this->tasks[] = $task;
    }

    public function current(): Task
    {
        return $this->tasks[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->tasks[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}

// Создаем список задач
$taskList = new TaskList();

// Добавляем задачи в список
$taskList->addTask(new Task('Task 1', 'Description 1'));
$taskList->addTask(new Task('Task 2', 'Description 2'));
$taskList->addTask(new Task('Task 3', 'Description 3'));

// Используем итератор для обхода списка задач
foreach ($taskList as $task) {
    echo "Task: {$task->name}, Description: {$task->description}\n";
}
