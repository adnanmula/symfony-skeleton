<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Tests\Application\Unsubscribe;

use AdnanMula\Skeleton\Application\User\Unsubscribe\UnsubscribeUserCommand;
use AdnanMula\Skeleton\Application\User\Unsubscribe\UnsubscribeUserCommandHandler;
use AdnanMula\Skeleton\Domain\Model\User\Exception\UserNotExistsException;
use AdnanMula\Skeleton\Domain\Model\User\UserRepository;
use AdnanMula\Skeleton\Domain\Service\User\UserRemover;
use AdnanMula\Skeleton\Tests\Mock\Domain\Model\User\UserMotherObject;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class UnsubscribeUserCommandHandlerTest extends TestCase
{
    private MockObject $repository;
    private UnsubscribeUserCommandHandler $handler;

    /** @test */
    public function given_subscribed_user_then_unsubscribe(): void
    {
        $reference = UserMotherObject::MOCK_REF;

        $this->repository->expects($this->once())
            ->method('byReference')
            ->with($reference)
            ->willReturn(UserMotherObject::buildDefault());

        $this->repository->expects($this->once())
            ->method('remove')
            ->with(UserMotherObject::buildDefault());

        ($this->handler)($this->command($reference));
    }

    /** @test */
    public function given_unsubscribed_user_then_throw_exception(): void
    {
        $this->expectException(UserNotExistsException::class);

        $reference = UserMotherObject::MOCK_REF;

        $this->repository->expects($this->once())
            ->method('byReference')
            ->with($reference)
            ->willReturn(null);

        ($this->handler)($this->command($reference));
    }

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);

        $this->handler = new UnsubscribeUserCommandHandler(
            new UserRemover($this->repository),
        );
    }

    private function command(string $reference): UnsubscribeUserCommand
    {
        return new UnsubscribeUserCommand($reference);
    }
}
