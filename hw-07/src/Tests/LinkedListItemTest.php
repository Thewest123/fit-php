<?php declare(strict_types=1);

namespace HW\Tests;

use HW\Lib\LinkedList;
use HW\Lib\LinkedListItem;
use PHPUnit\Framework\TestCase;

class LinkedListItemTest extends TestCase
{
    protected $list;
    protected $item;
    protected static $itemValue = "itemValue";

    public function setUp(): void
    {
        parent::setUp();
        $this->list = new LinkedList();
        $this->item = new LinkedListItem(self::$itemValue);
    }

    public function testItemGetValue()
    {
        $this->assertEquals(self::$itemValue, $this->item->getValue());
    }

    public function testItemGetSetValue()
    {
        $this->item->setValue("newValue");
        $this->assertEquals("newValue", $this->item->getValue());
    }

    public function testItemGetSetPrev()
    {
        $prevItem = new LinkedListItem("prev");
        $this->item->setPrev($prevItem);
        $this->assertSame($prevItem, $this->item->getPrev());
    }

    public function testItemGetSetNext()
    {
        $prevItem = new LinkedListItem("next");
        $this->item->setNext($prevItem);
        $this->assertSame($prevItem, $this->item->getNext());
    }

    public function testListGetSetFirst()
    {
        $this->list->setFirst($this->item);
        $this->assertSame($this->item, $this->list->getFirst());
    }

    public function testListGetSetLast()
    {
        $this->list->setLast($this->item);
        $this->assertSame($this->item, $this->list->getLast());
    }

    public function testListPrependListWhenEmpty()
    {
        $newItem = $this->list->prependList("prepend");

        // Assert new item was prepended as first
        $this->assertSame($newItem, $this->list->getFirst());
    }

    public function testListPrependListWhenNotEmpty()
    {
        // Prepare list
        $this->list->prependList("1");
        $this->list->prependList("2");
        $this->list->prependList("3");

        // Call function
        $second = $this->list->getFirst();
        $newItem = $this->list->prependList("prepend");

        // Assert new item was prepended as first
        $this->assertSame($newItem, $this->list->getFirst());

        if ($second === null)
            return;

        // Assert link from new item to second was made
        $this->assertSame($second, $this->list->getFirst()->getNext());

        // Assert link from second to new item was made
        $this->assertSame($newItem, $second->getPrev());
    }

    public function testListAppendListWhenEmpty()
    {
        $newItem = $this->list->appendList("append");

        // Assert new item was appended as last
        $this->assertSame($newItem, $this->list->getLast());
    }

    public function testListAppendListWhenNotEmpty()
    {
        // Prepare list
        $this->list->appendList("1");
        $this->list->appendList("2");
        $this->list->appendList("3");

        // Call function
        $penultimate = $this->list->getLast();
        $newItem = $this->list->appendList("append");

        // Assert new item was appended as last
        $this->assertSame($newItem, $this->list->getLast());

        if ($penultimate === null)
            return;

        // Assert link from new item to penultimate was made
        $this->assertSame($penultimate, $this->list->getLast()->getPrev());

        // Assert link from penultimate to new item was made
        $this->assertSame($newItem, $penultimate->getNext());
    }

    public function testListPrependItemWhenEmpty()
    {
        // Prepare list
        $item1 = $this->list->appendList("1");

        // Call function
        $newItem = $this->list->prependItem($item1, "0");

        $this->assertSame($newItem, $item1->getPrev());
        $this->assertSame($item1, $newItem->getNext());
    }

    public function testListAppendItemWhenEmpty()
    {
        // Prepare list
        $item1 = $this->list->appendList("1");

        // Call function
        $newItem = $this->list->appendItem($item1, "0");

        $this->assertSame($newItem, $item1->getNext());
        $this->assertSame($item1, $newItem->getPrev());
    }

    public function testListPrependItemWhenNotEmpty()
    {
        // Prepare list
        $item1 = $this->list->appendList("1");
        $item2 = $this->list->appendList("2");

        // Call function
        $newItem = $this->list->prependItem($item2, "1-2");

        $this->assertSame($newItem, $item2->getPrev());
        $this->assertSame($newItem, $item1->getNext());

        $this->assertSame($item1, $newItem->getPrev());
        $this->assertSame($item2, $newItem->getNext());
    }

    public function testListAppendItemWhenNotEmpty()
    {
        // Prepare list
        $item1 = $this->list->appendList("1");
        $item2 = $this->list->appendList("2");

        // Call function
        $newItem = $this->list->appendItem($item1, "1-2");

        $this->assertSame($newItem, $item2->getPrev());
        $this->assertSame($newItem, $item1->getNext());

        $this->assertSame($item1, $newItem->getPrev());
        $this->assertSame($item2, $newItem->getNext());
    }
}
