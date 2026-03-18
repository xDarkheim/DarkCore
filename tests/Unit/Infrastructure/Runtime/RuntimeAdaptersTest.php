<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Runtime;

use Darkheim\Infrastructure\Runtime\NativePostStore;
use Darkheim\Infrastructure\Runtime\NativeQueryStore;
use Darkheim\Infrastructure\Runtime\NativeRequestStore;
use Darkheim\Infrastructure\Runtime\NativeSessionStore;
use Darkheim\Infrastructure\Runtime\ServerContext;
use PHPUnit\Framework\TestCase;

final class RuntimeAdaptersTest extends TestCase
{
    protected function setUp(): void
    {
        $_GET = [];
        $_POST = [];
        $_REQUEST = [];
        $_SESSION = [];
        unset($_SERVER['REMOTE_ADDR']);
    }

    public function testNativeSessionStoreReadsWritesAndClearsSession(): void
    {
        $store = new NativeSessionStore();

        $this->assertFalse($store->has('username'));
        $store->set('username', 'darkheim');
        $this->assertTrue($store->has('username'));
        $this->assertSame('darkheim', $store->get('username'));
        $this->assertSame('fallback', $store->get('missing', 'fallback'));

        $store->clear();
        $this->assertSame([], $_SESSION);
    }

    public function testNativeQueryStoreReadsWritesAndChecksKeys(): void
    {
        $store = new NativeQueryStore();

        $this->assertFalse($store->has('page'));
        $store->set('page', 'rankings');
        $this->assertTrue($store->has('page'));
        $this->assertSame('rankings', $store->get('page'));
        $this->assertSame('home', $store->get('subpage', 'home'));
    }

    public function testNativeRequestStoreReadsRequestData(): void
    {
        $_REQUEST['subpage'] = 'gens';

        $store = new NativeRequestStore();

        $this->assertSame('gens', $store->get('subpage'));
        $this->assertSame('default', $store->get('missing', 'default'));
    }

    public function testNativePostStoreCountsPostPayload(): void
    {
        $_POST = ['txn_id' => 'abc123', 'payment_status' => 'Completed'];

        $store = new NativePostStore();

        $this->assertSame(2, $store->count());
    }

    public function testServerContextReturnsRemoteAddressOrNull(): void
    {
        $context = new ServerContext();
        $this->assertNull($context->remoteAddress());

        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $this->assertSame('127.0.0.1', $context->remoteAddress());
    }
}

