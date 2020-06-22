<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Tests\Application\Subscribe;

use AdnanMula\Skeleton\Application\User\Subscribe\SubscribeUserCommand;
use AdnanMula\Skeleton\Application\User\Subscribe\SubscribeUserCommandHandler;
use AdnanMula\Skeleton\Domain\Model\User\Exception\UserAlreadyExistsException;
use AdnanMula\Skeleton\Domain\Model\User\UserRepository;
use AdnanMula\Skeleton\Domain\Service\User\UserCreator;
use AdnanMula\Skeleton\Tests\Mock\Domain\Model\User\UserMotherObject;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SubscribeUserCommandHandlerTest extends TestCase
{
    private MockObject $repository;
    private SubscribeUserCommandHandler $handler;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);

        $this->handler = new SubscribeUserCommandHandler(
            new UserCreator($this->repository),
        );
    }

    /** @test */
    public function given_unsubscribed_user_then_subscribe(): void
    {
        $id = UserMotherObject::MOCK_ID;
        $reference = UserMotherObject::MOCK_REF;
        $name = UserMotherObject::MOCK_NAME;

        $this->repository->expects($this->once())
            ->method('byReference')
            ->with($reference)
            ->willReturn(null);

        $this->repository->expects($this->once())
            ->method('save')
            ->with(UserMotherObject::buildDefault());

        ($this->handler)($this->command($id, $reference, $name));
    }

    /** @test */
    public function given_subscribed_user_then_throw_exception(): void
    {
        $this->expectException(UserAlreadyExistsException::class);

        $id = UserMotherObject::MOCK_ID;
        $reference = UserMotherObject::MOCK_REF;
        $name = UserMotherObject::MOCK_NAME;

        $this->repository->expects($this->once())
            ->method('byReference')
            ->with($reference)
            ->willReturn(UserMotherObject::buildDefault());

        $this->repository->expects($this->never())->method('save');

        ($this->handler)($this->command($id, $reference, $name));
    }

    private function command(string $id, string $reference, string $username): SubscribeUserCommand
    {
        return new SubscribeUserCommand($id, $reference, $username);
    }
}
