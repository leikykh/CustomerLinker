<?php

namespace LinkedDataImporter\Model;

class Customer
{
    private int $id;
    private ?int $parentId;
    private string $email;
    private string $card;
    private string $phone;

    public function __construct(int $id, string $email, string $card, string $phone, ?int $parentId = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->card = $card;
        $this->phone = $phone;
        $this->parentId = $parentId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): void
    {
        $this->parentId = $parentId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCard(): string
    {
        return $this->card;
    }

    public function setCard(string $card): void
    {
        $this->card = $card;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'PARENT_ID' => $this->getParentId(),
            'EMAIL' => $this->getEmail(),
            'CARD' => $this->getCard(),
            'PHONE' => $this->getPhone()
        ];
    }
}