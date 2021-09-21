<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use FromHome\Cloudimg\Exceptions\SourceDoesNotExist;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use FromHome\Cloudimg\Contract\Models\SourceInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Source extends Model implements SourceInterface
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'domain',
        'provider', 'provider_key', 'provider_secret',
        'aws_region', 'aws_bucket', 'aws_end_point',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sign_key' => 'encrypted',
        'provider_key' => 'encrypted',
        'provider_secret' => 'encrypted',
    ];

    protected $hidden = [
        'sign_key',
        'provider_key',
        'provider_secret',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withoutGlobalScopes();
    }

    public function getId(): int
    {
        /** @psalm-var int */
        return $this->getKey();
    }

    public function getProviderName(): string
    {
        /** @psalm-var string */
        return $this->getAttribute('provider');
    }

    public function findById(int $id): SourceInterface
    {
        /** @var SourceInterface|null $model */
        $model = self::query()->find($id);

        if ($model === null) {
            throw SourceDoesNotExist::withId($id);
        }

        return $model;
    }

    public function findByDomain(string $domain): SourceInterface
    {
        /** @var SourceInterface|null $model */
        $model = self::query()->where('domain', $domain)->first();

        if ($model === null) {
            throw SourceDoesNotExist::withDomain($domain);
        }

        return $model;
    }

    public function getPlainKey(): string
    {
        /** @psalm-var string */
        return $this->getAttribute('provider_key');
    }

    public function getPlainSecret(): string
    {
        /** @psalm-var string */
        return $this->getAttribute('provider_secret');
    }

    public function getPlainSignKey(): string
    {
        /** @psalm-var string */
        return $this->getAttribute('sign_key');
    }

    public function getAwsConfig(): array
    {
        return [
            'driver' => 's3',
            'key' => $this->getPlainKey(),
            'secret' => $this->getPlainSecret(),
            'region' => $this->getAttribute('aws_region'),
            'bucket' => $this->getAttribute('aws_bucket'),
            'url' => null,
            'endpoint' => $this->getAttribute('aws_end_point'),
            'use_path_style_endpoint' => false,
        ];
    }
}
