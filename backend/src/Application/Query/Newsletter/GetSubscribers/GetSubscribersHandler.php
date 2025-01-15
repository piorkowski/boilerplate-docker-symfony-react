<?php

declare(strict_types=1);

namespace App\Application\Query\Newsletter\GetSubscribers;

use App\Domain\Model\Newsletter\NewsletterMember;
use App\Infrastructure\Repository\NewsletterMemberRepository;

final readonly class GetSubscribersHandler
{
    public function __construct(
        private NewsletterMemberRepository $newsletterMemberRepository,
    ) {
    }

    /** @return NewsletterMember[] */
    public function __invoke(GetSubscribersQuery $query): array
    {
        return $this->newsletterMemberRepository->findBy(!empty($query->criteria) ? $query->criteria : $this->prepareCriteria(), $query->orderBy ?? $this->prepareOrderBy());
    }

    /** @return array<string, bool> */
    private function prepareCriteria(): array
    {
        return [
            'active' => true,
            'acceptedTerms' => true,
        ];
    }

    /** @return array<string, 'ASC'> */
    private function prepareOrderBy(): array
    {
        return [
            'createdAt' => 'ASC',
        ];
    }
}
