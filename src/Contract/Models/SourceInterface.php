<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Contract\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface SourceInterface extends Arrayable, AwsCompatibleInterface
{
    public function user(): BelongsTo;

    /**
     * @return mixed
     */
    public function fill(array $attributes);

    /**
     * @return bool
     */
    public function save(array $options = []);

    public function findById(int $id): self;

    public function findByDomain(string $domain): self;

    public function getId(): int;

    public function getProviderName(): string;

    public function getPlainSignKey(): string;

    public function getPlainKey(): string;

    public function getPlainSecret(): string;
}
