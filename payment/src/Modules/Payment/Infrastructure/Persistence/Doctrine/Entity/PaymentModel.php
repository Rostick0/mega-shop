<?php

namespace App\Modules\Payment\Infrastructure\Persistence\Doctrine\Entity;

use App\Modules\Payment\Domain\ValueObject\CurrencyEnum;
use App\Modules\Payment\Domain\ValueObject\PaymentStatusEnum;
use App\Modules\Payment\Infrastructure\Persistence\Doctrine\Repository\DoctrinePaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrinePaymentRepository::class)]
class PaymentModel
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $external_reference = null;

    #[ORM\Column(length: 255)]
    private ?string $provider = null;

    #[ORM\Column(nullable: true)]
    private ?int $provider_payment_id = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(enumType: CurrencyEnum::class)]
    private ?CurrencyEnum $currency = null;
    #[ORM\Column(enumType: PaymentStatusEnum::class)]
    private ?PaymentStatusEnum $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getExternalReference(): ?string
    {
        return $this->external_reference;
    }

    public function setExternalReference(string $external_reference): static
    {
        $this->external_reference = $external_reference;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): static
    {
        $this->provider = $provider;

        return $this;
    }

    public function getProviderPaymentId(): ?int
    {
        return $this->provider_payment_id;
    }

    public function setProviderPaymentId(?int $provider_payment_id): static
    {
        $this->provider_payment_id = $provider_payment_id;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?CurrencyEnum
    {
        return $this->currency;
    }

    public function setCurrency(CurrencyEnum $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getStatus(): ?PaymentStatusEnum
    {
        return $this->status;
    }

    public function setStatus(PaymentStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
