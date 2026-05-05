<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Tests\Application\Unsubscribe;

use AdnanMula\Skeleton\Application\User\Unsubscribe\UnsubscribeUserCommand;
use AdnanMula\Skeleton\Application\User\Unsubscribe\UnsubscribeUserCommandHandler;
use AdnanMula\Skeleton\Domain\Model\User\Exception\UserNotExistsException;
use AdnanMula\Skeleton\Domain\Model\User\UserRepository;
use AdnanMula\Skeleton\Domain\Service\User\UserRemover;
use AdnanMula\Skeleton\Tests\Mock\Domain\Model\User\UserMotherObject;
use Assert\LazyAssertionException;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class UnsubscribeUserCommandHandlerTest extends TestCase
{
    private MockObject $repository;
    private UnsubscribeUserCommandHandler $handler;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);

        $this->handler = new UnsubscribeUserCommandHandler(
            new UserRemover($this->repository),
        );
    }

    #[AllowMockObjectsWithoutExpectations]
    public function testGivenBadCommandThenThrowException(): void
    {
        $this->expectException(LazyAssertionException::class);

        new UnsubscribeUserCommand('');
    }

    public function testGivenSubscribedUserThenUnsubscribe(): void
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

    public function testGivenUnsubscribedUserThenThrowException(): void
    {
        $this->expectException(UserNotExistsException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $reference = UserMotherObject::MOCK_REF;

        $this->repository->expects($this->once())
            ->method('byReference')
            ->with($reference)
            ->willReturn(null);

        ($this->handler)($this->command($reference));
    }

    private function command(string $reference): UnsubscribeUserCommand
    {
        return new UnsubscribeUserCommand($reference);
    }
}
