<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class HelperTest extends TestCase
{
    protected function tearDown(): void
    {
        unset($_ENV['QS_TEST_VAR'], $_SERVER['QS_TEST_VAR']);
    }

    public function testEnvReadsValueFromEnvironment(): void
    {
        $_ENV['QS_TEST_VAR'] = 'hello';

        $this->assertSame('hello', env('QS_TEST_VAR', 'default'));
    }

    public function testEnvFallsBackToDefaultWhenMissingOrEmpty(): void
    {
        $this->assertSame('default', env('QS_TEST_VAR', 'default'));

        $_ENV['QS_TEST_VAR'] = '';
        $this->assertSame('default', env('QS_TEST_VAR', 'default'));
    }

    public function testEnvKeepsFalsyStringValues(): void
    {
        $_ENV['QS_TEST_VAR'] = '0';

        $this->assertSame('0', env('QS_TEST_VAR', 'default'));
    }

    public function testEnvThrowsWhenMissingWithoutDefault(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('QS_TEST_VAR is not a defined .env variable');

        env('QS_TEST_VAR');
    }

    public function testThrowWhenUsesGivenExceptionClass(): void
    {
        throw_when(false, 'never thrown');

        $this->expectException(\InvalidArgumentException::class);
        throw_when(true, 'boom', \InvalidArgumentException::class);
    }

    public function testBasePathPointsToProjectRoot(): void
    {
        $this->assertFileExists(base_path('composer.json'));
        $this->assertSame(base_path() . '/src/Views', base_path('src/Views'));
    }

    public function testCollectReturnsCollection(): void
    {
        $collection = collect([1, 2, 3]);

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertSame([2, 4, 6], $collection->map(fn ($n) => $n * 2)->all());
    }

    #[DataProvider('stringHelperProvider')]
    public function testStringHelpers(string $function, array $args, string $expected): void
    {
        $this->assertSame($expected, $function(...$args));
    }

    public static function stringHelperProvider(): array
    {
        return [
            'str_after'       => ['str_after', ['app/Controllers/Home.php', '/'], 'Controllers/Home.php'],
            'str_after_last'  => ['str_after_last', ['app/Controllers/Home.php', '/'], 'Home.php'],
            'str_before'      => ['str_before', ['app/Controllers/Home.php', '/'], 'app'],
            'str_before_last' => ['str_before_last', ['app/Controllers/Home.php', '/'], 'app/Controllers'],
            'str_between'     => ['str_between', ['{name}', '{', '}'], 'name'],
            'no match'        => ['str_after_last', ['quicksite', '/'], 'quicksite'],
        ];
    }
}
