<?php
declare(strict_types=1);


namespace App\Application\Factory;


use App\Domain\Newsletter\NewsletterMember;

interface NewsletterMemberFactoryInterface
{
    public function create(): NewsletterMember;
}
