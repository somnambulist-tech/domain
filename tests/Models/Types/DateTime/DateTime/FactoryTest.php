<?php declare(strict_types=1);

namespace Somnambulist\Components\Tests\Models\Types\DateTime\DateTime;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Models\Types\DateTime\DateTime;
use Somnambulist\Components\Models\Types\DateTime\TimeZone;
use Somnambulist\Components\Tests\Models\Types\DateTime\Helpers;

#[Group('models')]
#[Group('models-types')]
#[Group('models-types-datetime')]
class FactoryTest extends TestCase
{
    use Helpers;

    public function testCreate()
    {
        $vo = new DateTime('2017-06-17 12:00:00');

        $this->assertEquals('2017-06-17 12:00:00', $vo->toString());
        $this->assertEquals('2017', $vo->year());
        $this->assertEquals('6', $vo->month());
        $this->assertEquals('17', $vo->day());
        $this->assertEquals('12', $vo->hour());
        $this->assertEquals('0', $vo->minute());
        $this->assertEquals('0', $vo->second());
        $this->assertEquals('1497715200', $vo->timestamp());
        $this->assertEquals('24', $vo->weekOfYear());
        $this->assertEquals('6', $vo->dayOfWeek());
        $this->assertEquals('167', $vo->dayOfYear());
        $this->assertEquals('30', $vo->daysInMonth());
    }

    public function testCreateViaFactory()
    {
        $vo = DateTime::parse('2017-06-17 12:00:00', new TimeZone('UTC'));

        $this->assertEquals('2017-06-17 12:00:00', $vo->toString());
    }

    public function testNow()
    {
        $vo = DateTime::now();

        $this->assertEquals(date('Y-m-d H:i:s'), $vo->toString());
        $this->assertEquals('America/Toronto', (string)$vo->timezone());
    }

    public function testCreateFromFormat()
    {
        $vo = DateTime::createFromFormat('Y-m-d H:i:s', '2017-06-17 12:00:00');

        $this->assertInstanceOf(DateTime::class, $vo);
        $this->assertEquals('2017-06-17 12:00:00', $vo->toString());
    }

    public function testCreateFromFormatRaisesExceptionIfInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        DateTime::createFromFormat('bob', '2017-06-17 12:00:00');
    }

    public function testCreateViaFactoryWithTimeZone()
    {
        $vo = DateTime::parse('2017-06-17 12:00:00', new TimeZone('UTC'));

        $this->assertEquals('2017-06-17 12:00:00', $vo->toString());
    }
}
