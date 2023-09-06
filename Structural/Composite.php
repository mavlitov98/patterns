<?php

declare(strict_types=1);

namespace Structural\Composite;

/**
 * Паттерн Composite.
 *
 * Есть абстрактный класс FileComponent, который предоставляет общий интерфейс для всех компонентов (классы-листы и классы-контейнеры).
 * У класса-листа File есть метод display(), который выводит имя файла соответствующим образом.
 *
 * Класс-контейнер Folder содержит в себе коллекцию дочерних компонентов (children).
 * У класса-контейнера есть методы add() и remove(), позволяющие добавлять и удалять дочерние компоненты.
 *
 * При вызове метода display() у класса-контейнера Folder, он выводит свое имя и затем рекурсивно вызывает метод display()
 * для каждого из дочерних компонентов, передавая им увеличенный отступ.
 *
 * В основном сценарии мы создаем объекты Folder, File и добавляем их друг к другу, формируя иерархию файловой системы.
 * Затем мы вызываем метод display() у корневого компонента root, который отображает всю структуру файлов и папок рекурсивно.
 *
 * Таким образом, паттерн "Компоновщик" позволяет обрабатывать отдельные объекты и их композиции единообразно,
 * что полезно, когда нужно работать с иерархическими структурами.
 */
// Абстрактный класс, описывающий общий интерфейс компонентов
abstract class FileComponent
{
    public function __construct(
        protected string $name,
    ) {
    }

    abstract public function display($indent = 0): void;
}

// Класс-лист, представляющий файл
class File extends FileComponent
{
    public function display($indent = 0): void
    {
        var_dump(str_repeat('-', $indent) . ' ' . $this->name . PHP_EOL);
    }
}

// Класс-контейнер, представляющий папку
class Folder extends FileComponent
{
    /** @var list<FileComponent> */
    private array $children = [];

    public function add(FileComponent $component): void
    {
        $this->children[] = $component;
    }

    public function display($indent = 0): void
    {
        var_dump(str_repeat('-', $indent) . ' ' . $this->name . PHP_EOL);

        foreach ($this->children as $child) {
            $child->display($indent + 2);
        }
    }
}

// Использование паттерна "Компоновщик"
$root = new Folder('Root');
$documents = new Folder('Documents');
$photos = new Folder('Photos');

$textFile = new File('Text.txt');
$imageFile = new File('Image.jpg');

$documents->add($textFile);
$photos->add($imageFile);

$root->add($documents);
$root->add($photos);

$root->display();
